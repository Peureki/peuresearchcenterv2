<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'id',
        'icon',
        'name',
        'description',
        'requirement',
        'locked_text',
        'type',
        'flags',
        'tiers',
        'prerequisites',
        'rewards',
        'bits',
        'point_cap',
    ];

    protected $casts = [
        'flags' => 'array',
        'tiers' => 'array',
        'prerequisites' => 'array',
        'rewards' => 'array',
        'bits' => 'array',
    ];

}
