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

    public function confirmation(){
        return $this->hasMany(Confirmation::class);
    }

    /*
     * SALVAGEABLES
     */

    public function copperFedSalvageable(){
        return $this->hasMany(CopperFedSalvageable::class); 
    }

    public function copperFedSalvageableDropRate(){
        return $this->hasMany(CopperFedSalvageableDropRate::class); 
    }

    public function runecraftersSalvageable(){
        return $this->hasMany(runecraftersSalvageable::class); 
    }

    public function runecraftersSalvageableDropRate(){
        return $this->hasMany(runecraftersSalvageableDropRate::class);
    }

    public function silverFedSalvageable(){
        return $this->hasMany(SilverFedSalvageable::class);
    }

    public function silverFedSalvageableDropRate(){
        return $this->hasMany(SilverFedSalvageableDropRate::class); 
    }

    public function mixedSalvageable(){
        return $this->hasMany(MixedSalvageable::class);
    }

    public function mixedSalvageableDropRate(){
        return $this->hasMany(MixedSalvageableDropRate::class); 
    }

    public function exotic(){
        return $this->hasMany(Exotic::class); 
    }
}
