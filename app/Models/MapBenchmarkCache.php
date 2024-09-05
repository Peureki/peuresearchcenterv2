<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapBenchmarkCache extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cache_key',
        'includes',
        'sell_order_setting',
        'tax',
        'drop_rates',
        'benchmarks'
    ];
}
