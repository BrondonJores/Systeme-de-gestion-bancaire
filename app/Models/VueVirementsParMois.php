<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueVirementsParMois extends Model
{
    protected $table = 'vue_virements_par_mois';
    public $timestamps = false;
    protected $fillable = ['mois','nombre','total'];
}
