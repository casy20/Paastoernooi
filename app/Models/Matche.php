<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matche extends Model
{
    /** @use HasFactory<\Database\Factories\MatcheFactory> */
    use HasFactory;

    protected $fillable = [
        'team_1_id',
        'team_2_id',
        'team_1_score',
        'team_2_score',
        'field',
        'referee',
        'start_time',
        'end_time',
        'pause_minutes',
        'type',
        'tournament_id',
    ];

    public function team1(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_1_id');
    }

    public function team2(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_2_id');
    }
}
