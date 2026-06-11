<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Models\LeagueMatch;
use App\Models\MatchResult;
use App\Models\Player;
use App\Models\PlayerStat;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        $matches = LeagueMatch::with(['league', 'homeTeam', 'awayTeam', 'result'])
            ->orderBy('match_date', 'desc')
            ->paginate(15);
        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        $leagues = League::orderBy('name')->get();
        $teams   = Team::with('league')->orderBy('name')->get();
        return view('admin.matches.create', compact('leagues', 'teams'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'league_id'    => 'required|exists:leagues,id',
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'venue'        => 'nullable|string|max:255',
            'match_date'   => 'required|date',
            'week'         => 'nullable|integer|min:1',
        ]);

        LeagueMatch::create($data);
        return redirect()->route('admin.matches.index')->with('success', 'Match scheduled successfully.');
    }

    public function show(LeagueMatch $match)
    {
        $match->load(['league', 'homeTeam.players', 'awayTeam.players', 'result', 'playerStats.player', 'playerStats.team']);
        return view('admin.matches.show', compact('match'));
    }

    public function edit(LeagueMatch $match)
    {
        $leagues = League::orderBy('name')->get();
        $teams   = Team::with('league')->orderBy('name')->get();
        return view('admin.matches.edit', compact('match', 'leagues', 'teams'));
    }

    public function update(Request $request, LeagueMatch $match)
    {
        $data = $request->validate([
            'league_id'    => 'required|exists:leagues,id',
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'venue'        => 'nullable|string|max:255',
            'match_date'   => 'required|date',
            'week'         => 'nullable|integer|min:1',
            'status'       => 'required|in:scheduled,completed,postponed,cancelled',
        ]);

        $match->update($data);
        return redirect()->route('admin.matches.index')->with('success', 'Match updated.');
    }

    public function destroy(LeagueMatch $match)
    {
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Match deleted.');
    }

    public function recordResult(LeagueMatch $match)
    {
        $match->load(['homeTeam.players', 'awayTeam.players', 'result', 'playerStats']);
        return view('admin.matches.result', compact('match'));
    }

    public function storeResult(Request $request, LeagueMatch $match)
    {
        $data = $request->validate([
            'home_q1' => 'required|integer|min:0',
            'home_q2' => 'required|integer|min:0',
            'home_q3' => 'required|integer|min:0',
            'home_q4' => 'required|integer|min:0',
            'away_q1' => 'required|integer|min:0',
            'away_q2' => 'required|integer|min:0',
            'away_q3' => 'required|integer|min:0',
            'away_q4' => 'required|integer|min:0',
            'notes'   => 'nullable|string',
            'stats'   => 'nullable|array',
            'stats.*.player_id'      => 'required|exists:players,id',
            'stats.*.team_id'        => 'required|exists:teams,id',
            'stats.*.points'         => 'required|integer|min:0',
            'stats.*.assists'        => 'required|integer|min:0',
            'stats.*.rebounds'       => 'required|integer|min:0',
            'stats.*.steals'         => 'required|integer|min:0',
            'stats.*.blocks'         => 'required|integer|min:0',
            'stats.*.fouls'          => 'required|integer|min:0',
            'stats.*.minutes_played' => 'required|integer|min:0',
        ]);

        MatchResult::updateOrCreate(
            ['league_match_id' => $match->id],
            collect($data)->except('stats')->toArray()
        );

        if (!empty($data['stats'])) {
            PlayerStat::where('league_match_id', $match->id)->delete();
            foreach ($data['stats'] as $stat) {
                PlayerStat::create(array_merge($stat, ['league_match_id' => $match->id]));
            }
        }

        $match->update(['status' => 'completed']);

        return redirect()->route('admin.matches.show', $match)->with('success', 'Result recorded successfully.');
    }
}
