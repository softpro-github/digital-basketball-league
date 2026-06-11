<?php

namespace Database\Seeders;

use App\Models\League;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $league1 = League::where('name', 'Edo Basketball League')->first();
        $league2 = League::where('name', 'National Universities Basketball League')->first();

        // Create coach users
        $coaches = [
            User::create(['name' => 'Michael Okafor',    'email' => 'coach1@basketball.com', 'password' => Hash::make('coach123'), 'role' => 'coach']),
            User::create(['name' => 'Emmanuel Ihejirika','email' => 'coach2@basketball.com', 'password' => Hash::make('coach123'), 'role' => 'coach']),
            User::create(['name' => 'Peter Eze',         'email' => 'coach3@basketball.com', 'password' => Hash::make('coach123'), 'role' => 'coach']),
            User::create(['name' => 'Samuel Idahosa',    'email' => 'coach4@basketball.com', 'password' => Hash::make('coach123'), 'role' => 'coach']),
            User::create(['name' => 'Tunde Adesanya',    'email' => 'coach5@basketball.com', 'password' => Hash::make('coach123'), 'role' => 'coach']),
            User::create(['name' => 'Chike Obi',         'email' => 'coach6@basketball.com', 'password' => Hash::make('coach123'), 'role' => 'coach']),
        ];

        // League 1 teams
        Team::create(['name' => 'Iyamho Ballers',         'league_id' => $league1->id, 'coach_id' => $coaches[0]->id, 'home_court' => 'Iyamho Sports Complex']);
        Team::create(['name' => 'Auchi Warriors',          'league_id' => $league1->id, 'coach_id' => $coaches[1]->id, 'home_court' => 'Auchi Indoor Arena']);
        Team::create(['name' => 'Ekpoma Giants',           'league_id' => $league1->id, 'coach_id' => $coaches[2]->id, 'home_court' => 'ESUT Sports Hall, Ekpoma']);
        Team::create(['name' => 'Uromi Storm',             'league_id' => $league1->id, 'coach_id' => $coaches[3]->id, 'home_court' => 'Uromi Stadium Court']);

        // League 2 teams
        Team::create(['name' => 'Lagos Underdogs',         'league_id' => $league2->id, 'coach_id' => $coaches[4]->id, 'home_court' => 'National Stadium, Lagos']);
        Team::create(['name' => 'Benin City Kings',        'league_id' => $league2->id, 'coach_id' => $coaches[5]->id, 'home_court' => 'Samuel Ogbemudia Stadium']);
        Team::create(['name' => 'Abuja Senators',          'league_id' => $league2->id, 'coach_id' => null,           'home_court' => 'Moshood Abiola Stadium, Abuja']);
        Team::create(['name' => 'Port Harcourt Panthers',  'league_id' => $league2->id, 'coach_id' => null,           'home_court' => 'Sharks FC Stadium Court']);
    }
}
