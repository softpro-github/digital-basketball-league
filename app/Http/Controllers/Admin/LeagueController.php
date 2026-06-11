<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index()
    {
        $leagues = League::withCount('teams')->latest()->paginate(10);
        return view('admin.leagues.index', compact('leagues'));
    }

    public function create()
    {
        return view('admin.leagues.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'season'      => 'required|string|max:50',
            'status'      => 'required|in:upcoming,active,completed',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        League::create($data);
        return redirect()->route('admin.leagues.index')->with('success', 'League created successfully.');
    }

    public function show(League $league)
    {
        $standings = $league->standings();
        $matches   = $league->matches()->with(['homeTeam', 'awayTeam', 'result'])->orderBy('match_date')->get();
        return view('admin.leagues.show', compact('league', 'standings', 'matches'));
    }

    public function edit(League $league)
    {
        return view('admin.leagues.edit', compact('league'));
    }

    public function update(Request $request, League $league)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'season'      => 'required|string|max:50',
            'status'      => 'required|in:upcoming,active,completed',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        $league->update($data);
        return redirect()->route('admin.leagues.index')->with('success', 'League updated successfully.');
    }

    public function destroy(League $league)
    {
        $league->delete();
        return redirect()->route('admin.leagues.index')->with('success', 'League deleted.');
    }
}
