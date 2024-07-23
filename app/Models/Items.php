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

    // *
    // * RELATIONSHIPS
    // * 
    public function bag(){
        return $this->hasMany(Bag::class); 
    }

    public function bagDropRate(){
        return $this->hasMany(BagDropRate::class); 
    }

    public function containerDropRate(){
        return $this->hasMany(ContainerDropRate::class); 
    }

    public function researchNotes(): HasMany {
        return $this->hasMany(ResearchNotes::class);
    }

    public function fish(){
        return $this->hasMany(Fish::class);
    }

    public function fishDropRate(){
        return $this->hasMany(FishDropRate::class);
    }

    public function fishingHoleDropRate(){
        return $this->hasMany(FishingHoleDropRate::class);
    }
}
