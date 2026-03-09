<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(5)->create();

        User::factory()->create([
            'name' => 'admin',
            'prenom' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('Admin123'),
        ]);

        User::factory()->create([
            'name' => 'Jores',
            'prenom' => 'Brondon',
            'role' => 'conseiller',
            'password' => bcrypt('Brad123'),
        ]);
    }
}
