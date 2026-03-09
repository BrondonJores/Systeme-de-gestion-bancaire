<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteBancaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'type',
        'solde',
        'statut',
        'has_interest',
        'has_fees',
        'taux_interet',
        'frais',
        'plafond',
        'rib'
    ];

    //Chaque compte appartient à un client spécifique : relation BelongsTO
    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //Un compte peut effectuer plusieurs virements : relation HasMany
    public function virementSortant()
    {
        return $this->hasMany(Virement::class, 'id_compte_destinataire');
    }

    //Un compte peut recevoir plusieurs virements : relation HasMany
    public function virementEntrant()
    {
        return $this->hasMany(Virement::class, 'id_compte_emetteur');
    }

    public function cartebancaire()
    {
        return $this->hasMany(CarteBancaire::class, 'id_compte');
    }

    public function suspendre()
    {
        $this->statut = 'inactif';
        $this->save();
    }

    public function activer()
    {
        $this->statut = 'actif';
        $this->save();
    }

    public function fermer()
    {
        $this->statut = 'ferme';
    }

    public function scopeActive($query){
        return $query->where('statut', 'actif');
    }

    public function scopeInactive($query){
        return $query->where('statut', 'inactif');
    }

    public function scopeFerme($query){
        return $query->where('statut', 'ferme');
    }
}
