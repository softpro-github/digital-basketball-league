<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    protected $fillable = ['name', 'season', 'status', 'start_date', 'end_date', 'description'];

    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(LeagueMatch::class);
    }

    public function standings()
    {
        $teams = $this->teams()->with(['homeMatches.result', 'awayMatches.result'])->get();

        return $teams->map(function ($team) {
            $played = $won = $lost = $pf = $pa = 0;

            foreach ($team->homeMatches()->where('status', 'completed')->get() as $match) {
                if (!$match->result) continue;
                $played++;
                $pf += $match->result->home_total;
                $pa += $match->result->away_total;
                $match->result->home_total > $match->result->away_total ? $won++ : $lost++;
            }

            foreach ($team->awayMatches()->where('status', 'completed')->get() as $match) {
                if (!$match->result) continue;
                $played++;
                $pf += $match->result->away_total;
                $pa += $match->result->home_total;
                $match->result->away_total > $match->result->home_total ? $won++ : $lost++;
            }

            return [
                'team'       => $team,
                'played'     => $played,
                'won'        => $won,
                'lost'       => $lost,
                'points_for' => $pf,
                'points_against' => $pa,
                'diff'       => $pf - $pa,
                'win_pct'    => $played > 0 ? round(($won / $played) * 100, 1) : 0,
            ];
        })->sortByDesc('won')->values();
    }
}
