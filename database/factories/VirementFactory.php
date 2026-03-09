<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Virement;
use App\Models\CompteBancaire;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Virement>
 */
class VirementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_compte_emetteur' => CompteBancaire::factory(),
            'id_compte_destinataire' => CompteBancaire::factory(),
            'montant' => fake()->randomFloat(2, 100, 5000),
            'type' => fake()->randomElement(['transfert', 'depot', 'retrait', 'frais', 'interet']),
            'statut' => 'en cours', // par défaut en cours
            'reference' => strtoupper(fake()->unique()->bothify('BTR########???')),
            'description' => fake()->sentence(),
        ];
    }
}
