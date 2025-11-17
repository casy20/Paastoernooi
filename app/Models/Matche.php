<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'type',
        'tournament_id',
    ];
}
