<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VueComptesParStatut;
use App\Models\VueStatutVirements;
use App\Models\VueTopClients;
use App\Models\VueTotalSolde;
use App\Models\VueVirementsParMois;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $totalSolde = VueTotalSolde::first()?->total_solde ?? 0;
        $comptesParStatut = VueComptesParStatut::all();
        $virementsParMois = VueVirementsParMois::orderBy('mois','desc')->limit(12)->get()->reverse()->values();
        $statutVirements = VueStatutVirements::all();
        $topClients = VueTopClients::all();

        return view('dashboard.index', compact(
            'totalSolde','comptesParStatut','virementsParMois','statutVirements','topClients'
        ));
    }
}
