<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Models\LeagueMatch;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $player = $user->player()->with(['team.league'])->first();

        $upcomingMatches = collect();
        $recentResults   = collect();
        $standings       = collect();

        if ($player?->team) {
            $tid = $player->team_id;

            $upcomingMatches = LeagueMatch::with(['homeTeam', 'awayTeam', 'league'])
                ->where('status', 'scheduled')
                ->where(fn($q) => $q->where('home_team_id', $tid)->orWhere('away_team_id', $tid))
                ->orderBy('match_date')
                ->limit(5)
                ->get();

            $recentResults = LeagueMatch::with(['homeTeam', 'awayTeam', 'result'])
                ->where('status', 'completed')
                ->where(fn($q) => $q->where('home_team_id', $tid)->orWhere('away_team_id', $tid))
                ->latest('updated_at')
                ->limit(5)
                ->get();

            $standings = $player->team->league->standings();
        }

        $activeLeagues = League::where('status', 'active')->with('teams')->get();

        return view('player.dashboard', compact('player', 'upcomingMatches', 'recentResults', 'standings', 'activeLeagues'));
    }

    public function fixtures()
    {
        $leagues = League::with(['matches' => fn($q) => $q->with(['homeTeam', 'awayTeam'])->orderBy('match_date')])
            ->where('status', 'active')
            ->get();
        return view('player.fixtures', compact('leagues'));
    }

    public function standings()
    {
        $leagues = League::where('status', 'active')->get();
        return view('player.standings', compact('leagues'));
    }
}
