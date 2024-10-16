<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NodeBenchmarkDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'node_benchmark_id',
        'node_id',
        'drop_rate',
        'level',
    ];

    //  *
    //  * FOREIGN KEYS
    //  * 
    public function node(){
        return $this->belongsTo(Node::class);
    }
    public function nodeCount(){
        return $this->belongsTo(NodeBenchmark::class);
    }
}
