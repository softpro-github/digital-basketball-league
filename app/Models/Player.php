<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $fillable = [
        'user_id', 'team_id', 'first_name', 'last_name',
        'jersey_number', 'position', 'age', 'height', 'weight', 'photo',
    ];

    public function user(): BelongsTo  { return $this->belongsTo(User::class); }
    public function team(): BelongsTo  { return $this->belongsTo(Team::class); }
    public function stats(): HasMany   { return $this->hasMany(PlayerStat::class); }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function averageStats(): array
    {
        $stats = $this->stats;
        $count = $stats->count();
        if ($count === 0) return ['points' => 0, 'assists' => 0, 'rebounds' => 0, 'steals' => 0, 'blocks' => 0];

        return [
            'points'   => round($stats->avg('points'), 1),
            'assists'  => round($stats->avg('assists'), 1),
            'rebounds' => round($stats->avg('rebounds'), 1),
            'steals'   => round($stats->avg('steals'), 1),
            'blocks'   => round($stats->avg('blocks'), 1),
        ];
    }
}
