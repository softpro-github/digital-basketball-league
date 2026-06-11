<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = ['name', 'league_id', 'coach_id', 'logo', 'home_court'];

    public function league(): BelongsTo  { return $this->belongsTo(League::class); }
    public function coach(): BelongsTo   { return $this->belongsTo(User::class, 'coach_id'); }
    public function players(): HasMany   { return $this->hasMany(Player::class); }

    public function homeMatches(): HasMany
    {
        return $this->hasMany(LeagueMatch::class, 'home_team_id');
    }

    public function awayMatches(): HasMany
    {
        return $this->hasMany(LeagueMatch::class, 'away_team_id');
    }
}
