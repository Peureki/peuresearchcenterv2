<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapBenchmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'type',
        'sample_size',
        'latest_run',
    ];

    public function dropRates(){
        return $this->hasMany(MapBenchmarkDropRate::class); 
    }


}
