<?php

namespace App\Services\CompteBancaire;

use App\Services\CompteBancaire\CompteBancaireServiceInterface;

class InteretDecorateur implements CompteBancaireServiceInterface
{
    protected $service;
    protected $taux;

    public function __construct(CompteBancaireServiceInterface $service, float $taux)
    {
        $this->service = $service;
        $this->taux = $taux;
    }
    public function deposer(float $montant)
    {
       $this->service->deposer($montant);
    }

    public function retirer(float $montant)
    {
        $this->service->retirer($montant);
    }

    public function getSolde(): float
    {
        $solde = $this->service->getSolde();
        $this->taux = $solde * ($this->taux/100);
        return $solde + $this->taux;
    }

}
