<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatheringTool extends Model
{
    protected $fillable = [
        'id',
        'item_id',
        'type',
        'max_cast',
        'min_cast',
        'animation_locked',
    ];

    public function item(){
        return $this->hasOne(Items::class);
    }
}
