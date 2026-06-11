<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchResult extends Model
{
    protected $fillable = [
        'league_match_id',
        'home_q1', 'home_q2', 'home_q3', 'home_q4',
        'away_q1', 'away_q2', 'away_q3', 'away_q4',
        'notes',
    ];

    public function match(): BelongsTo
    {
        return $this->belongsTo(LeagueMatch::class, 'league_match_id');
    }

    public function winner(): ?Team
    {
        if ($this->home_total > $this->away_total) return $this->match->homeTeam;
        if ($this->away_total > $this->home_total) return $this->match->awayTeam;
        return null;
    }
}
