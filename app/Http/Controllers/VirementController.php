<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVirementRequest;
use App\Http\Requests\UpdateVirementRequest;
use App\Models\CompteBancaire;
use App\Models\Virement;
use App\Services\CompteBancaire\CompteBancaireService;
use App\Services\CompteBancaire\FraisDecorateur;
use App\Services\CompteBancaire\InteretDecorateur;
use App\Services\CompteBancaire\PlafondDecorateur;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = Virement::with(['compteEmetteur.proprietaire', 'compteDestinataire.proprietaire']);
        if(auth()->user()->role === 'client'){
            $query->whereHas('compteEmetteur', function ($qy) {
                $qy->where('user_id', auth()->id());
            })->orWhereHas('compteDestinataire', function ($qy) {
                $qy->where('user_id', auth()->id());
            });
        }else{
            $this->authorize('viewAny', Virement::class);
        }

        $virements = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('virements.index', compact('virements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Virement::class);

        $user = auth()->user();
        $comptes = match ($user->role){
            'admin', 'conseiller' => CompteBancaire::all(),
            'client' => CompteBancaire::where('user_id', auth()->id())->get(),
            'default' => abort(403)
        };

        return view('virements.create', compact('comptes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVirementRequest $request)
    {
        $user = auth()->user();

        try {
            DB::transaction(function () use ($request, $user) {

                $emetteur = CompteBancaire::findOrFail($request->id_compte_emetteur);
                $destinataire = CompteBancaire::findOrFail($request->id_compte_destinataire);

                // Vérifications
                if ($emetteur->statut !== 'actif') {
                    throw new Exception("Compte émetteur non actif.");
                }

                if ($destinataire->statut !== 'actif') {
                    throw new \Exception("Compte destinataire non actif.");
                }

                if ($user->role === 'client' && $emetteur->user_id !== $user->id) {
                    throw new \Exception("Vous n'êtes pas propriétaire du compte émetteur.");
                }

                $service = new CompteBancaireService($emetteur);

                if ($emetteur->has_fees) {
                    $service = new FraisDecorateur($service, $emetteur->frais);
                }

                if ($emetteur->plafond > 0) {
                    $service = new PlafondDecorateur($service, $emetteur->plafond);
                }

                if ($request->montant > $service->getSolde()) {
                    throw new \Exception("Solde insuffisant (montant + frais).");
                }

                // Création du virement
                Virement::create($request->validated());
            });

            return redirect()->route('virements.index')
                ->with('success', 'Virement créé et placé en attente de validation.');

        } catch (\Exception $e) {
            // Gestion douce de l'erreur
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Virement $virement)
    {
        $this->authorize('view', $virement);
        $virement->load(['compteEmetteur.proprietaire', 'compteDestinataire.proprietaire']);

        return view('virements.show', compact('virement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Virement $virement)
    {
        $this->authorize('update', $virement);

        return view('virements.edit', compact('virement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVirementRequest $request, Virement $virement)
    {
        $this->authorize('update', $virement);
        $virement->update($request->validated());

        return redirect()->route('virements.show', $virement)->with('success', 'Virement mis à jour avec succes.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Virement $virement)
    {
        $this->authorize('delete', $virement);
        $virement->delete();

        return redirect()->route('virements.index')->with('success', 'Virement supprimé avec succes.');
    }

    public function valider(Virement $virement)
    {
        $this->authorize('valider', $virement);

        DB::transaction(function () use ($virement) {

            $emetteur = $virement->compteEmetteur;
            $destinataire = $virement->compteDestinataire;

            $service = new CompteBancaireService($emetteur);

            if ($emetteur->has_fees) {
                $service = new FraisDecorateur($service, $emetteur->frais);
            }

            if ($emetteur->plafond > 0) {
                $service = new PlafondDecorateur($service, $emetteur->plafond);
            }

            $montantFinal = $service->montantAvecFrais($virement->montant);

            if ($montantFinal > $emetteur->solde) {
                abort(400, "Solde insuffisant pour finaliser le virement.");
            }

            $service->retirer($virement->montant);
            $destinataire->solde += $virement->montant;
            $destinataire->save();
            // Statut
            $virement->effectuer();
        });

        return back()->with('success', 'Virement validé.');
    }

    public function annuler(Virement $virement)
    {
        $this->authorize('echouer', $virement);

        $virement->echouer();
        $virement->save();

        return back()->with('error', 'Virement marqué comme échoué.');
    }
}
