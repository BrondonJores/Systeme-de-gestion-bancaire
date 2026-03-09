<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompteBancaireRequest;
use App\Http\Requests\UpdateCompteBancaireRequest;
use App\Models\CompteBancaire;
use Illuminate\Http\Request;

class CompteBancaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $query = CompteBancaire::with('proprietaire');
        if($user->role === 'client'){
            $query->where('user_id', $user->id);
        }else{
            $this->authorize('viewAny', CompteBancaire::class);
        }

        $comptebancaires = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('comptes.index', compact('comptebancaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', CompteBancaire::class);
        return view('comptes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompteBancaireRequest $request)
    {
        $this->authorize('create', CompteBancaire::class);
        $comtebancaire = CompteBancaire::create($request->validated());
        return redirect()->route('comptes.show', $comtebancaire)->with('success', 'Compte Bancaire créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompteBancaire $comptebancaire)
    {
        $this->authorize('view', $comptebancaire);
        $comptebancaire->load('proprietaire', 'cartebancaire', 'virementEntrant', 'virementSortant');

        return view('comptes.show', compact('comptebancaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompteBancaire $comptebancaire)
    {
        $this->authorize('update', $comptebancaire);
        return view('comptes.edit', compact('comptebancaire'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompteBancaireRequest $request, CompteBancaire $comptebancaire)
    {
        $this->authorize('update', $comptebancaire);
        $comptebancaire->update($request->validated());

        return redirect()->route('comptes.show', $comptebancaire)->with('success','Compte bancaire modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompteBancaire $comptebancaire)
    {
        $this->authorize('delete', $comptebancaire);
        $comptebancaire->delete();

        return redirect()->route('comptes.index')->with('success', 'Compte bancaire supprimé');

    }

    public function suspendre(CompteBancaire $comptebancaire)
    {
        $this->authorize('valider', $comptebancaire);
        $comptebancaire->suspendre();

        return redirect()->back()->with('success', 'Compte suspendu avec succes');
    }

    public function activer(CompteBancaire $comptebancaire)
    {
        $this->authorize('valider', $comptebancaire);
        $comptebancaire->activer();

        return redirect()->back()->with('success', 'Compte activé avec succes');
    }

    public function fermer(CompteBancaire $comptebancaire)
    {
        $this->authorize('valider', $comptebancaire);
        $comptebancaire->fermer();

        return redirect()->back()->with('success', 'Compte fermé avec succes');
    }
}
