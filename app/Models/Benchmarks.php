<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benchmarks extends Model
{
    use HasFactory;

    protected $table = '';

    protected $fillable = [
        'drop',
        'drop_rate',

    ];
    
    // Since there are multiple benchmarks with the same table params, set each individual table db 
    // Map benchmarks, Fishing benchmarks, etc. 
    // Example use: 
    // $nameOfVariable = (new Benchmarks)->setTable('NAME_OF_DB_TABLE')->get(); 
    // $mapBenchmarks = (new Benchmarks)->setTable('map_benchmarks')->get(); 
    public function setTable($table){
        $this->table = $table; 
        return $this; 
    }
}
