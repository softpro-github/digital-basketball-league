<?php

namespace Database\Seeders;

use App\Models\League;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    public function run(): void
    {
        League::insert([
            [
                'name'        => 'Edo Basketball League',
                'season'      => '2025/2026',
                'status'      => 'active',
                'start_date'  => '2025-10-01',
                'end_date'    => '2026-08-31',
                'description' => 'The premier basketball competition for clubs in Edo State.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'National Universities Basketball League',
                'season'      => '2026',
                'status'      => 'active',
                'start_date'  => '2026-03-01',
                'end_date'    => '2026-12-31',
                'description' => 'Inter-university basketball competition across Nigeria.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
