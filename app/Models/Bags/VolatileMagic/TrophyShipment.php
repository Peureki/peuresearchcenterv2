<?php

namespace App\Models\Bags\VolatileMagic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Items;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrophyShipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'name',
        'drop_rate',
    ];

    public function items(): BelongsTo {
        return $this->belongsTo(Items::class, 'item_id');
    }
}
