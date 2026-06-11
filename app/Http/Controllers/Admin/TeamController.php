<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with(['league', 'coach'])->withCount('players')->latest()->paginate(10);
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $leagues = League::orderBy('name')->get();
        $coaches = User::where('role', 'coach')->orderBy('name')->get();
        return view('admin.teams.create', compact('leagues', 'coaches'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'league_id'  => 'required|exists:leagues,id',
            'coach_id'   => 'nullable|exists:users,id',
            'home_court' => 'nullable|string|max:255',
        ]);

        Team::create($data);
        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
    }

    public function show(Team $team)
    {
        $team->load(['league', 'coach', 'players']);
        return view('admin.teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $leagues = League::orderBy('name')->get();
        $coaches = User::where('role', 'coach')->orderBy('name')->get();
        return view('admin.teams.edit', compact('team', 'leagues', 'coaches'));
    }

    public function update(Request $request, Team $team)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'league_id'  => 'required|exists:leagues,id',
            'coach_id'   => 'nullable|exists:users,id',
            'home_court' => 'nullable|string|max:255',
        ]);

        $team->update($data);
        return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully.');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Team deleted.');
    }
}
