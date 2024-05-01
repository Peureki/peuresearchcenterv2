<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bags\TrophyShipment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Items extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'chat_link',
        'description',
        'icon',
        'level',
        'name',
        'rarity',
        'type',
        'vendor_value',
        'buy_quantity',
        'buy_price',
        'sell_quantity',
        'sell_price',
    ];

    public function researchNotes(): HasMany {
        return $this->hasMany(ResearchNotes::class);
    }
}
