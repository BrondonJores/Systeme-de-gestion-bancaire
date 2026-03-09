<?php


use App\Http\Controllers\CarteBancaireController;
use App\Http\Controllers\CompteBancaireController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VirementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('filament.client.auth.login'); // route de login Filament
});

