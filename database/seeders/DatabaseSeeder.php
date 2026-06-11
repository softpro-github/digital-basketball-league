<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Core admin account
        User::firstOrCreate(
            ['email' => 'admin@basketball.com'],
            ['name' => 'Administrator', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        $this->call([
            LeagueSeeder::class,
            TeamSeeder::class,
            PlayerSeeder::class,
            MatchSeeder::class,
        ]);
    }
}
