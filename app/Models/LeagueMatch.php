<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LeagueMatch extends Model
{
    protected $fillable = ['league_id', 'home_team_id', 'away_team_id', 'venue', 'match_date', 'week', 'status'];

    protected $casts = ['match_date' => 'datetime'];

    public function league(): BelongsTo    { return $this->belongsTo(League::class); }
    public function homeTeam(): BelongsTo  { return $this->belongsTo(Team::class, 'home_team_id'); }
    public function awayTeam(): BelongsTo  { return $this->belongsTo(Team::class, 'away_team_id'); }
    public function result(): HasOne       { return $this->hasOne(MatchResult::class); }
    public function playerStats(): HasMany { return $this->hasMany(PlayerStat::class); }
}
