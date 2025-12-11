<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\HttpKernel\Profiler\Profile;

class School extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'school_type',
        'creator_id',
    ];

    public function creator_id() : BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
