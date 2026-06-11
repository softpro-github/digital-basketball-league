<?php

namespace Database\Seeders;

use App\Models\LeagueMatch;
use App\Models\League;
use App\Models\MatchResult;
use App\Models\Player;
use App\Models\PlayerStat;
use App\Models\Team;
use Illuminate\Database\Seeder;

class MatchSeeder extends Seeder
{
    public function run(): void
    {
        $l1 = League::where('name', 'Edo Basketball League')->first();
        $l2 = League::where('name', 'National Universities Basketball League')->first();

        $t = Team::orderBy('id')->get()->keyBy('name');

        // ── League 1 Fixtures ──────────────────────────────────────────────────
        // Week 1 (completed)
        $m1 = $this->match($l1->id, $t['Iyamho Ballers'],  $t['Auchi Warriors'],          '2026-04-10 16:00:00', 'Iyamho Sports Complex', 1, 'completed');
        $m2 = $this->match($l1->id, $t['Ekpoma Giants'],   $t['Uromi Storm'],             '2026-04-10 18:00:00', 'ESUT Sports Hall, Ekpoma', 1, 'completed');

        // Week 2 (completed)
        $m3 = $this->match($l1->id, $t['Auchi Warriors'],  $t['Ekpoma Giants'],           '2026-04-17 16:00:00', 'Auchi Indoor Arena', 2, 'completed');
        $m4 = $this->match($l1->id, $t['Uromi Storm'],     $t['Iyamho Ballers'],          '2026-04-17 18:00:00', 'Uromi Stadium Court', 2, 'completed');

        // Week 3 (completed)
        $m5 = $this->match($l1->id, $t['Iyamho Ballers'],  $t['Ekpoma Giants'],           '2026-05-01 16:00:00', 'Iyamho Sports Complex', 3, 'completed');
        $m6 = $this->match($l1->id, $t['Auchi Warriors'],  $t['Uromi Storm'],             '2026-05-01 18:00:00', 'Auchi Indoor Arena', 3, 'completed');

        // Week 4 (past date – PENDING results, no result recorded yet)
        $this->match($l1->id, $t['Ekpoma Giants'],  $t['Iyamho Ballers'],                 '2026-06-08 16:00:00', 'ESUT Sports Hall, Ekpoma', 4, 'scheduled');
        $this->match($l1->id, $t['Uromi Storm'],    $t['Auchi Warriors'],                 '2026-06-08 18:00:00', 'Uromi Stadium Court', 4, 'scheduled');

        // Week 5 (upcoming – final round)
        $this->match($l1->id, $t['Iyamho Ballers'], $t['Uromi Storm'],                    '2026-07-05 16:00:00', 'Iyamho Sports Complex', 5, 'scheduled');
        $this->match($l1->id, $t['Ekpoma Giants'],  $t['Auchi Warriors'],                 '2026-07-05 18:00:00', 'ESUT Sports Hall, Ekpoma', 5, 'scheduled');

        // ── League 2 Fixtures ──────────────────────────────────────────────────
        $this->match($l2->id, $t['Lagos Underdogs'],       $t['Benin City Kings'],        '2026-06-25 15:00:00', 'National Stadium, Lagos', 1, 'scheduled');
        $this->match($l2->id, $t['Abuja Senators'],        $t['Port Harcourt Panthers'],  '2026-06-25 17:00:00', 'Moshood Abiola Stadium', 1, 'scheduled');
        $this->match($l2->id, $t['Benin City Kings'],      $t['Abuja Senators'],          '2026-07-10 15:00:00', 'Samuel Ogbemudia Stadium', 2, 'scheduled');
        $this->match($l2->id, $t['Port Harcourt Panthers'],$t['Lagos Underdogs'],         '2026-07-10 17:00:00', 'Sharks FC Stadium Court', 2, 'scheduled');

        // ── Record Results for completed matches ───────────────────────────────
        // Match 1: Iyamho Ballers 86 – Auchi Warriors 84
        $this->result($m1, 22, 18, 26, 20, 18, 22, 20, 24);
        $this->playerStats($m1, $t['Iyamho Ballers'],  [[24,6,4,2,0,2,32],[18,3,3,1,0,2,28],[16,2,6,1,1,3,30],[14,1,8,0,2,2,28],[14,2,10,0,2,2,26]]);
        $this->playerStats($m1, $t['Auchi Warriors'],  [[22,7,3,2,0,3,32],[20,2,4,1,0,2,28],[18,3,5,1,1,2,30],[14,1,7,0,2,3,28],[10,2,9,0,3,2,26]]);

        // Match 2: Ekpoma Giants 84 – Uromi Storm 78
        $this->result($m2, 20, 24, 18, 22, 20, 18, 22, 18);
        $this->playerStats($m2, $t['Ekpoma Giants'],   [[22,8,3,3,0,2,34],[20,3,4,1,0,2,30],[18,2,6,0,1,3,28],[14,1,7,0,2,2,26],[10,1,10,0,3,1,24]]);
        $this->playerStats($m2, $t['Uromi Storm'],     [[20,6,3,2,0,3,32],[18,2,4,1,0,2,28],[16,3,5,0,1,2,28],[14,1,8,0,2,3,26],[10,2,9,0,2,2,24]]);

        // Match 3: Auchi Warriors 95 – Ekpoma Giants 88
        $this->result($m3, 28, 22, 20, 25, 22, 24, 20, 22);
        $this->playerStats($m3, $t['Auchi Warriors'],  [[26,8,4,3,0,2,34],[22,3,3,1,0,2,30],[20,2,6,1,1,3,30],[14,1,8,0,2,2,26],[13,2,9,0,3,1,22]]);
        $this->playerStats($m3, $t['Ekpoma Giants'],   [[24,7,3,2,0,3,32],[22,3,4,1,0,2,30],[18,2,5,0,1,2,28],[14,1,8,0,2,3,26],[10,1,10,0,3,2,24]]);

        // Match 4: Uromi Storm 90 – Iyamho Ballers 84
        $this->result($m4, 24, 22, 20, 24, 20, 22, 24, 18);
        $this->playerStats($m4, $t['Uromi Storm'],     [[28,7,4,3,0,2,34],[22,3,3,1,0,2,28],[18,2,6,0,1,3,28],[12,1,8,0,2,2,26],[10,2,10,0,3,1,24]]);
        $this->playerStats($m4, $t['Iyamho Ballers'],  [[24,6,3,2,0,2,32],[18,3,4,1,0,2,28],[16,2,6,1,1,3,28],[14,1,7,0,2,2,26],[12,2,9,0,2,2,24]]);

        // Match 5: Iyamho Ballers 91 – Ekpoma Giants 86
        $this->result($m5, 24, 20, 26, 21, 20, 22, 24, 20);
        $this->playerStats($m5, $t['Iyamho Ballers'],  [[26,7,4,2,0,2,34],[22,4,3,1,0,2,30],[18,2,6,1,1,3,28],[14,1,8,0,2,2,26],[11,2,10,0,3,1,24]]);
        $this->playerStats($m5, $t['Ekpoma Giants'],   [[24,6,3,2,0,3,32],[20,3,4,1,0,2,28],[18,2,6,0,1,2,28],[14,1,8,0,2,3,26],[10,1,9,0,3,2,24]]);

        // Match 6: Auchi Warriors 88 – Uromi Storm 82
        $this->result($m6, 22, 24, 20, 22, 20, 22, 18, 22);
        $this->playerStats($m6, $t['Auchi Warriors'],  [[24,7,4,3,0,2,34],[22,3,3,1,0,2,30],[18,2,6,0,1,3,28],[14,1,8,0,2,2,26],[10,2,9,0,3,1,22]]);
        $this->playerStats($m6, $t['Uromi Storm'],     [[22,6,3,2,0,3,32],[20,2,4,1,0,2,28],[16,3,5,0,1,2,28],[14,1,7,0,2,2,26],[10,2,9,0,2,2,24]]);
    }

    private function match(int $leagueId, Team $home, Team $away, string $date, string $venue, int $week, string $status): LeagueMatch
    {
        return LeagueMatch::create([
            'league_id'    => $leagueId,
            'home_team_id' => $home->id,
            'away_team_id' => $away->id,
            'match_date'   => $date,
            'venue'        => $venue,
            'week'         => $week,
            'status'       => $status,
        ]);
    }

    private function result(LeagueMatch $match, int $hq1, int $hq2, int $hq3, int $hq4, int $aq1, int $aq2, int $aq3, int $aq4): void
    {
        MatchResult::create([
            'league_match_id' => $match->id,
            'home_q1' => $hq1, 'home_q2' => $hq2, 'home_q3' => $hq3, 'home_q4' => $hq4,
            'away_q1' => $aq1, 'away_q2' => $aq2, 'away_q3' => $aq3, 'away_q4' => $aq4,
        ]);
    }

    // $stats rows: [points, assists, rebounds, steals, blocks, fouls, minutes]
    private function playerStats(LeagueMatch $match, Team $team, array $stats): void
    {
        $players = Player::where('team_id', $team->id)->orderBy('id')->get();
        foreach ($players as $i => $player) {
            if (!isset($stats[$i])) break;
            [$pts, $ast, $reb, $stl, $blk, $fls, $min] = $stats[$i];
            PlayerStat::create([
                'league_match_id' => $match->id,
                'player_id'       => $player->id,
                'team_id'         => $team->id,
                'points'          => $pts,
                'assists'         => $ast,
                'rebounds'        => $reb,
                'steals'          => $stl,
                'blocks'          => $blk,
                'fouls'           => $fls,
                'minutes_played'  => $min,
            ]);
        }
    }
}
