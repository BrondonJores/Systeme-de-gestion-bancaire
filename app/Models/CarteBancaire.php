<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteBancaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_compte',
        'numero_carte',
        'type_carte',
        'proprietaire',
        'date_expiration',
        'cvv',
        'is_actif'
    ];

    public function compte()
    {
        return $this->belongsTo(CompteBancaire::class, 'id_compte');
    }

    public function proprietaire()
    {
        return $this->compte->proprietaire;
    }

    public function suspendu()
    {
        $this->is_actif = false;
        $this->save();
    }

    public function actif()
    {
        $this->is_actif = true;
        $this->save();
    }

    public function scopeActive($query)
    {
        return $query->where('is_actif', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_actif', false);
    }
}
