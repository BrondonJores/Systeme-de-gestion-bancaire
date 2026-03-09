<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CompteBancaire;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompteBancaire>
 */
class CompteBancaireFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => fake()->randomElement(['courant', 'epargne']),
            'solde' => fake()->randomFloat(2, 1000, 10000),
            'statut' => 'actif',
            'has_interest' => false,
            'taux_interet' => 0,
            'has_fees' => false,
            'frais' => 0,
            'plafond' => fake()->randomFloat(2, 1000, 5000),
            'rib' => strtoupper(fake()->unique()->iban('MA')),
        ];
    }
}
