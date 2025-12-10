<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    protected $fillable = [
        'brand_id',
        'type_id',
        'name',
        'originUrl',
    ];
}
