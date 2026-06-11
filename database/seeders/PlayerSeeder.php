<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        $teams = Team::orderBy('id')->get()->keyBy('name');

        // [first, last, jersey, position, age, height, weight, email|null]
        $roster = [
            'Iyamho Ballers' => [
                ['Emeka',       'Okafor',     '5',  'PG', 24, '182cm', '78kg',  'player1@basketball.com'],
                ['Chidi',       'Nwosu',      '10', 'SG', 22, '190cm', '82kg',  'player2@basketball.com'],
                ['Babatunde',   'Adeleke',    '15', 'SF', 25, '196cm', '90kg',  null],
                ['Seun',        'Adewale',    '20', 'PF', 26, '202cm', '100kg', null],
                ['Musa',        'Ibrahim',    '32', 'C',  27, '210cm', '110kg', null],
            ],
            'Auchi Warriors' => [
                ['Kingsley',    'Eze',        '7',  'PG', 23, '180cm', '76kg',  'player3@basketball.com'],
                ['Victor',      'Amadi',      '14', 'SG', 24, '188cm', '84kg',  null],
                ['Sunday',      'Okonkwo',    '21', 'SF', 25, '194cm', '88kg',  null],
                ['Felix',       'Udoh',       '33', 'PF', 26, '200cm', '98kg',  null],
                ['Emmanuel',    'Essien',     '42', 'C',  28, '208cm', '112kg', null],
            ],
            'Ekpoma Giants' => [
                ['Goodluck',    'Nwachukwu',  '4',  'PG', 22, '179cm', '75kg',  'player4@basketball.com'],
                ['Daniel',      'Adeyemi',    '11', 'SG', 23, '191cm', '83kg',  null],
                ['Ahmed',       'Garba',      '22', 'SF', 24, '195cm', '89kg',  null],
                ['Prosper',     'Obi',        '31', 'PF', 25, '203cm', '102kg', null],
                ['Chukwuemeka', 'Udo',        '45', 'C',  27, '212cm', '115kg', null],
            ],
            'Uromi Storm' => [
                ['Nnamdi',      'Osei',       '3',  'PG', 23, '183cm', '79kg',  'player5@basketball.com'],
                ['Tunde',       'Balogun',    '12', 'SG', 24, '189cm', '85kg',  null],
                ['Dike',        'Okeke',      '23', 'SF', 25, '197cm', '91kg',  null],
                ['Ikenna',      'Nweze',      '34', 'PF', 26, '204cm', '101kg', null],
                ['Obinna',      'Okorie',     '44', 'C',  28, '211cm', '113kg', null],
            ],
            'Lagos Underdogs' => [
                ['Taiwo',       'Adesanya',   '1',  'PG', 21, '178cm', '74kg',  null],
                ['Rotimi',      'Fadahunsi',  '9',  'SG', 22, '187cm', '81kg',  null],
                ['Lekan',       'Adewuyi',    '17', 'SF', 23, '193cm', '87kg',  null],
                ['Tobi',        'Olanrewaju', '28', 'PF', 24, '201cm', '99kg',  null],
                ['Jide',        'Afolabi',    '40', 'C',  25, '209cm', '111kg', null],
            ],
            'Benin City Kings' => [
                ['Osaro',       'Omoruyi',    '2',  'PG', 22, '181cm', '77kg',  null],
                ['Eghosa',      'Ogieva',     '13', 'SG', 23, '189cm', '83kg',  null],
                ['Erhun',       'Omoregie',   '18', 'SF', 24, '196cm', '90kg',  null],
                ['Oghenekaro',  'Efosa',      '29', 'PF', 25, '202cm', '100kg', null],
                ['Osagie',      'Obaseki',    '41', 'C',  26, '210cm', '112kg', null],
            ],
            'Abuja Senators' => [
                ['Yusuf',       'Abdullahi',  '6',  'PG', 23, '180cm', '77kg',  null],
                ['Kabir',       'Musa',       '16', 'SG', 24, '188cm', '83kg',  null],
                ['Adamu',       'Sule',       '24', 'SF', 25, '195cm', '89kg',  null],
                ['Bello',       'Yahaya',     '35', 'PF', 26, '201cm', '99kg',  null],
                ['Ibrahim',     'Tanko',      '50', 'C',  27, '209cm', '110kg', null],
            ],
            'Port Harcourt Panthers' => [
                ['Chinedu',     'Okoro',      '8',  'PG', 22, '182cm', '78kg',  null],
                ['Ifeanyi',     'Obi',        '19', 'SG', 23, '190cm', '84kg',  null],
                ['Kelechi',     'Nwosu',      '26', 'SF', 24, '194cm', '88kg',  null],
                ['Chisom',      'Eze',        '37', 'PF', 25, '202cm', '101kg', null],
                ['Ebuka',       'Okafor',     '48', 'C',  27, '211cm', '114kg', null],
            ],
        ];

        foreach ($roster as $teamName => $players) {
            $team = $teams[$teamName] ?? null;
            if (!$team) continue;

            foreach ($players as [$first, $last, $jersey, $pos, $age, $height, $weight, $email]) {
                $userId = null;
                if ($email) {
                    $user = User::create([
                        'name'     => "$first $last",
                        'email'    => $email,
                        'password' => Hash::make('player123'),
                        'role'     => 'player',
                    ]);
                    $userId = $user->id;
                }

                Player::create([
                    'user_id'       => $userId,
                    'team_id'       => $team->id,
                    'first_name'    => $first,
                    'last_name'     => $last,
                    'jersey_number' => $jersey,
                    'position'      => $pos,
                    'age'           => $age,
                    'height'        => $height,
                    'weight'        => $weight,
                ]);
            }
        }
    }
}
