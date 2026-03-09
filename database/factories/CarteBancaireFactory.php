<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CarteBancaire;
use App\Models\CompteBancaire;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarteBancaire>
 */
class CarteBancaireFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_compte' => CompteBancaire::factory(),
            'numero_carte' => fake()->unique()->creditCardNumber(),
            'date_expiration' => fake()->creditCardExpirationDate(),
            'type_carte' => fake()->randomElement(['debit', 'credit']),
            'proprietaire' => function(array $attributes) {
                $compte = CompteBancaire::find($attributes['id_compte']);
                return $compte ? $compte->proprietaire->name : fake()->name();
            },
            'cvv' => fake()->numberBetween(100, 999),
            'is_actif' => true,
        ];
    }
}
