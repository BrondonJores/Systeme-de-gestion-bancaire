<?php

namespace App\Services\CompteBancaire;

use App\Services\CompteBancaire\CompteBancaireServiceInterface;

use Exception;

class PlafondDecorateur implements CompteBancaireServiceInterface
{
    protected $service;
    protected $plafond;

    public function __construct(CompteBancaireServiceInterface $service, float $plafond)
    {
        $this->service = $service;
        $this->plafond = $plafond;
    }

    public function deposer(float $montant)
    {
        $this->service->deposer($montant);
    }

    public function retirer(float $montant)
    {
        if($montant < $this->plafond){
            $this->service->retirer($montant);
        }else{
            throw new Exception("Montant supérieur au plafond de retrait de {$this->plafond} !");
        }
    }

    public function getSolde(): float
    {
        return $this->service->getSolde();
    }

    public function montantAvecFrais($montant)
    {
        // On délègue au service principal
        return $this->service->montantAvecFrais($montant);
    }
}
