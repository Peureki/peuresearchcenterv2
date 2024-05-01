<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Items;

class Bag extends Model
{
    use HasFactory;

    protected $table = '';

    protected $fillable = [
        'item_id',
        'name',
        'drop_rate',
    ];
    // Relationship between Bag <-> Items dbs
    // Use BagDB->items (match the name) to access the item's id within the Items db 
    public function items(): BelongsTo {
        return $this->belongsTo(Items::class, 'item_id');
    }
    // Since there are multiple bags with the same table params, set each individual table db 
    // Example use: 
    // $nameOfBagVariable = (new Bag)->setTable('NAME_OF_DB_TABLE')->get(); 
    // $heavyCraftingBag = (new Bag)->setTable('heavy_crafting_bag')->get(); 
    public function setTable($table){
        $this->table = $table; 
        return $this; 
    }
}
