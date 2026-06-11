<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::with(['team.league', 'user'])->latest()->paginate(15);
        return view('admin.players.index', compact('players'));
    }

    public function create()
    {
        $teams = Team::with('league')->orderBy('name')->get();
        return view('admin.players.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'team_id'       => 'nullable|exists:teams,id',
            'jersey_number' => 'nullable|string|max:10',
            'position'      => 'nullable|in:PG,SG,SF,PF,C',
            'age'           => 'nullable|integer|min:10|max:60',
            'height'        => 'nullable|string|max:20',
            'weight'        => 'nullable|string|max:20',
            'email'         => 'nullable|email|unique:users,email',
            'password'      => 'nullable|min:6',
        ]);

        $user = null;
        if ($request->filled('email')) {
            $user = User::create([
                'name'     => "{$data['first_name']} {$data['last_name']}",
                'email'    => $request->email,
                'password' => Hash::make($request->password ?? 'password'),
                'role'     => 'player',
            ]);
        }

        Player::create(array_merge(
            collect($data)->except(['email', 'password'])->toArray(),
            ['user_id' => $user?->id]
        ));

        return redirect()->route('admin.players.index')->with('success', 'Player registered successfully.');
    }

    public function show(Player $player)
    {
        $player->load(['team.league', 'stats.match.homeTeam', 'stats.match.awayTeam']);
        $averages = $player->averageStats();
        return view('admin.players.show', compact('player', 'averages'));
    }

    public function edit(Player $player)
    {
        $teams = Team::with('league')->orderBy('name')->get();
        return view('admin.players.edit', compact('player', 'teams'));
    }

    public function update(Request $request, Player $player)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'team_id'       => 'nullable|exists:teams,id',
            'jersey_number' => 'nullable|string|max:10',
            'position'      => 'nullable|in:PG,SG,SF,PF,C',
            'age'           => 'nullable|integer|min:10|max:60',
            'height'        => 'nullable|string|max:20',
            'weight'        => 'nullable|string|max:20',
        ]);

        $player->update($data);
        return redirect()->route('admin.players.index')->with('success', 'Player updated successfully.');
    }

    public function destroy(Player $player)
    {
        $player->delete();
        return redirect()->route('admin.players.index')->with('success', 'Player deleted.');
    }
}
