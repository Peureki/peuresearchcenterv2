<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NodeBenchmarkCombination extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'node_benchmark_id',
        'pick_id',
        'axe_id',
        'sickle_id',
        'most_valued_item_id',
        'pick',
        'axe',
        'sickle',
    ];

    //  *
    //  * FOREIGN KEYS
    //  * 
    public function nodeCount(){
        return $this->belongsTo(NodeBenchmark::class);
    }
    public function pick(){
        return $this->belongsTo(Items::class, 'pick_id', 'id');
    }
    public function axe(){
        return $this->belongsTo(Items::class, 'axe_id', 'id');
    }
    public function sickle(){
        return $this->belongsTo(Items::class, 'sickle_id', 'id');
    }
    public function mostValuedItemID(){
        return $this->belongsTo(Items::class, 'most_valued_item_id', 'id');
    }
}
