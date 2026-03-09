<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CompteBancaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompteBancaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('role', 'client')->get()->each(function ($user) {

            CompteBancaire::factory()->create([
                'user_id' => $user->id,
                'type' => 'courant',
                'has_fees' => true,
                'frais' => 20,
                'plafond' => 3000,
            ]);

            CompteBancaire::factory()->create([
                'user_id' => $user->id,
                'type' => 'epargne',
                'has_interest' => true,
                'taux_interet' => 3.0,
                'plafond' => 5000,
            ]);
        });
    }

}
