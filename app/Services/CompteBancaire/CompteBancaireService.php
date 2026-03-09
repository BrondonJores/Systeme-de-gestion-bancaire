<?php

namespace App\Services\CompteBancaire;

use App\Models\CompteBancaire;
use App\Services\CompteBancaire\CompteBancaireServiceInterface;

class CompteBancaireService implements CompteBancaireServiceInterface
{
    protected $compteBancaire;
    public function __construct(CompteBancaire $compteBancaire)
    {
        $this->compteBancaire = $compteBancaire;
    }
    public function deposer(float $montant)
    {
        $this->compteBancaire->solde+=$montant;
        $this->compteBancaire->save();
    }

    public function retirer(float $montant)
    {
        $this->compteBancaire->solde-=$montant;
        $this->compteBancaire->save();
    }

    public function getSolde(): float
    {
        return $this->compteBancaire->solde;
    }

    public function montantAvecFrais($montant): float
    {
        return $montant;
    }

}
