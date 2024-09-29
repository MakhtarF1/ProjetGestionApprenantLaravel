<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Exécutez les graines de la base de données.
     *
     * @return void
     */
    public function run()
    {
        // Créez 50 utilisateurs fictifs
        User::factory()->count(50)->create();
    }
}
