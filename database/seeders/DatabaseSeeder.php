<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Materiel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         //User::factory(1)->create();

        User::factory()->create([
            'name' => 'rsekoua',
            'email' => 'rsekoua@local.host',
            'password' => bcrypt('password'),
        ]);
        Employe::factory()->count(4)->create();
        Materiel::factory()->count(10)->create();
    }
}
