<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueComptesParStatut extends Model
{
    protected $table = 'vue_comptes_par_statut';
    public $timestamps = false;
    protected $fillable = ['statut','total'];
}
