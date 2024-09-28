<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtherRecipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'output_item_id',
        'output_item_count',
        'disciplines',
        'merchant',
        'name',
        'merchant_data_hash',
        'ingredients',
    ];

    protected $casts = [
        'disciplines' => 'array',
        'ingredients' => 'array',
        'merchant' => 'array',
    ];

    /*
     * FOREIGN KEYS
     */
    public function outputItem(): BelongsTo {
        return $this->belongsTo(Items::class, 'output_item_id');
    }
}
