<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Virement extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_compte_emetteur',
        'id_compte_destinataire',
        'montant',
        'type',
        'statut',
        'reference',
        'description',
    ];

    //Un virement provient d'un seul compte emetteur : relation belongsTo
    public function compteEmetteur() {
        return $this->belongsTo(CompteBancaire::class, 'id_compte_destinataire');
    }

    //Un virement concerne un seul compte destinataire : relation belongsTo
    public function compteDestinataire() {
        return $this->belongsTo(CompteBancaire::class, 'id_compte_emetteur');
    }

    public function encours()
    {
        $this->statut = 'en cours';
        $this->save();
    }

    public function effectuer()
    {
        $this->statut = 'effectue';
        $this->save();
    }

    public function echouer()
    {
        $this->statut = 'echoue';
    }

    public function scopeEncours($query){
        return $query->where('statut', 'en cours');
    }

    public function scopeEffectue($query){
        return $query->where('statut', 'effectue');
    }

    public function scopeEchouer($query){
        return $query->where('statut', 'echoue');
    }
}
