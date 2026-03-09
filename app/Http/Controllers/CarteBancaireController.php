<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarteBancaireRequest;
use App\Http\Requests\UpdateCarteBancaireRequest;
use App\Models\CarteBancaire;
use App\Models\CompteBancaire;
use Illuminate\Http\Request;

class CarteBancaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = auth()->user();
        $query = CarteBancaire::with(['compte.proprietaire']);

        if($user->role === 'client'){
            $query->whereHas('compte', fn($q) => $q->where('user_id', $user->id));
        }else{
            $this->authorize('viewAny', CarteBancaire::class);
        }

        $cartesBancaires = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('cartes.index', compact('cartesBancaires'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', CarteBancaire::class);

        $user = auth()->user();
        $comptes = match($user->role){
            'admin', 'conseiller' => CompteBancaire::all(),
            'client' => CompteBancaire::where('user_id', $user->id),
            'default' => abort(403)
        };

        return view('cartes.create', compact('comptes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarteBancaireRequest $request)
    {
        $comptes = CompteBancaire::findOrFail($request->id_compte);
        $this->authorize('create', $comptes);

        CarteBancaire::create($request->validated());

        return redirect()->route('cartes.index')->with('success', 'Carte bancaire ajouté avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(CarteBancaire $carteBancaire)
    {
        $this->authorize('view', $carteBancaire);
        $carteBancaire->load(['compte.proprietaire']);

        return view('cartes.show', compact('carteBancaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CarteBancaire $carteBancaire)
    {
        $this->authorize('update', $carteBancaire);
        $comptes = CompteBancaire::all();

        return view('cartes.edit', compact('carteBancaire', 'comptes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarteBancaireRequest $request, CarteBancaire $carteBancaire)
    {
        $this->authorize('update', $carteBancaire);
        $carteBancaire->update($request->validated());

        return redirect()->route('cartes.show', $carteBancaire)->with('success', 'Carte bancaire modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CarteBancaire $carteBancaire)
    {
        $this->authorize('delete', $carteBancaire);
        $carteBancaire->delete();

        return redirect()->route('cartes.index')->with('success', 'Carte bancaire supprimé avec succes');
    }

    public function suspendre(CarteBancaire $carteBancaire)
    {
        $this->authorize('update', $carteBancaire);
        $carteBancaire->suspendu();

        return redirect()->back()->with('success', 'Carte suspendue avec succes');
    }
    public function activer(CarteBancaire $carteBancaire)
    {
        $this->authorize('update', $carteBancaire);
        $carteBancaire->actif();

        return redirect()->back()->with('success', 'Carte activée avec succes');
    }
}
