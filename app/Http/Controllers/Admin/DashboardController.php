<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Models\LeagueMatch;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalLeagues'  => League::count(),
            'totalTeams'    => Team::count(),
            'totalPlayers'  => Player::count(),
            'totalUsers'    => User::count(),
            'upcomingMatches' => LeagueMatch::with(['homeTeam', 'awayTeam', 'league'])
                ->where('status', 'scheduled')
                ->where('match_date', '>=', now())
                ->orderBy('match_date')
                ->limit(5)
                ->get(),
            'recentResults' => LeagueMatch::with(['homeTeam', 'awayTeam', 'result'])
                ->where('status', 'completed')
                ->latest('updated_at')
                ->limit(5)
                ->get(),
            'activeLeagues'   => League::where('status', 'active')->with('teams')->get(),
            'pendingResults'  => LeagueMatch::with(['homeTeam', 'awayTeam', 'league'])
                ->where('status', 'scheduled')
                ->where('match_date', '<', now())
                ->whereDoesntHave('result')
                ->orderBy('match_date')
                ->limit(10)
                ->get(),
        ]);
    }
}
