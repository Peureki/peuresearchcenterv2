<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Items;

class Shipment extends Model
{
    use HasFactory;

    protected $table = '';

    protected $fillable = [
        'item_id',
        'name',
        'drop_rate',
    ];

    public function items(): BelongsTo {
        return $this->belongsTo(Items::class, 'item_id');
    }

    public function setTable($table){
        $this->table = $table; 
        return $this; 
    }
}
