<?php

namespace Database\Seeders;

use App\Models\CompteBancaire;
use App\Models\Virement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $compteBancaires = CompteBancaire::all();
        foreach ($compteBancaires as $compteBancaireEmetteur) {
            $compteBancairedestinataire = $compteBancaires->where('id', '!=', $compteBancaireEmetteur->id)->random();
            virement::factory()->create([
                'id_compte_emetteur' => $compteBancaireEmetteur->id,
                'id_compte_destinataire' => $compteBancairedestinataire->id,
            ]);
        }
    }
}
