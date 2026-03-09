<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueTopClients extends Model
{
    protected $table = 'vue_top_clients';
    public $timestamps = false;
    protected $fillable = ['id','name','total_solde'];
}
