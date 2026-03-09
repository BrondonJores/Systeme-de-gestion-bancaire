<?php

namespace App\Services\CompteBancaire;

use App\Services\CompteBancaire\CompteBancaireServiceInterface;

class FraisDecorateur implements CompteBancaireServiceInterface
{
    protected $service;
    protected $frais;

    public function __construct(CompteBancaireServiceInterface $service, float $frais)
    {
        $this->service = $service;
        $this->frais = $frais;
    }
    public function deposer(float $montant)
    {
        $this->service->deposer($montant);
    }

    public function retirer(float $montant)
    {
        $this->service->retirer($montant+$this->frais);
    }

    public function getSolde(): float
    {
        return $this->service->getSolde();
    }

    public function montantAvecFrais($montant)
    {
        return $this->service->montantAvecFrais($montant) + $this->frais;
    }

}
