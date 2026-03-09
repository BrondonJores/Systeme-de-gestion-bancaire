<?php

namespace Database\Seeders;

use App\Models\CarteBancaire;
use App\Models\CompteBancaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarteBancaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompteBancaire::all()->each(function ($compteBancaire) {
            CarteBancaire::factory(1)->create([
                'id_compte' => $compteBancaire->id,]
            );
        });
    }
}
