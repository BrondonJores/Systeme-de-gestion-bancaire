<?php

namespace App\Services\CompteBancaire;

interface CompteBancaireServiceInterface
{
    public function deposer(float $montant);
    public function retirer(float $montant);
    public function getSolde(): float;
}
