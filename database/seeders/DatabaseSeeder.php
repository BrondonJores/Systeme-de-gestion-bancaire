<?php

namespace Database\Seeders;

use App\Models\CompteBancaire;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
           UserSeeder::class,
           CompteBancaireSeeder::class,
           VirementSeeder::class,
           CarteBancaireSeeder::class,
        ]);
    }
}
