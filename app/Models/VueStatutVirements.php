<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueStatutVirements extends Model
{
    protected $table = 'vue_statut_virements';
    public $timestamps = false;
    protected $fillable = ['statut','total'];
}
