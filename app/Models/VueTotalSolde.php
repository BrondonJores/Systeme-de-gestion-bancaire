<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueTotalSolde extends Model
{
    protected $table = 'vue_total_solde';
    public $timestamps = false;
    protected $fillable = ['total_solde'];
}
