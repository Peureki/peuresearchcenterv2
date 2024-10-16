<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NodeBenchmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'type',
        'sample_size',
        'time',
    ];

    /*
     * RELATIONSHIPS
     */

     public function dropRate(){
        return $this->hasMany(NodeBenchmarkDropRate::class); 
    }
}
