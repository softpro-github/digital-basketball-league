<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\LeagueMatch;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $teams = $user->coachedTeams()->with(['league', 'players'])->get();

        $teamIds = $teams->pluck('id');

        $upcomingMatches = LeagueMatch::with(['homeTeam', 'awayTeam', 'league'])
            ->where('status', 'scheduled')
            ->where(fn($q) => $q->whereIn('home_team_id', $teamIds)->orWhereIn('away_team_id', $teamIds))
            ->orderBy('match_date')
            ->limit(5)
            ->get();

        $recentResults = LeagueMatch::with(['homeTeam', 'awayTeam', 'result'])
            ->where('status', 'completed')
            ->where(fn($q) => $q->whereIn('home_team_id', $teamIds)->orWhereIn('away_team_id', $teamIds))
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return view('coach.dashboard', compact('teams', 'upcomingMatches', 'recentResults'));
    }

    public function team(int $teamId)
    {
        $user = Auth::user();
        $team = $user->coachedTeams()->with(['players.stats', 'league'])->findOrFail($teamId);

        $matches = LeagueMatch::with(['homeTeam', 'awayTeam', 'result'])
            ->where('home_team_id', $team->id)->orWhere('away_team_id', $team->id)
            ->orderBy('match_date', 'desc')
            ->get();

        return view('coach.team', compact('team', 'matches'));
    }
}
