<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NodeDropRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'node_id',
        'item_id',
        'currency_id',
        'drop_rate',
    ];

    //  *
    //  * FOREIGN KEYS
    //  * 
    public function item(){
        return $this->belongsTo(Items::class);
    }
    public function node(){
        return $this->belongsTo(Node::class);
    }
    public function currency(){
        return $this->belongsTo(Currencies::class);
    }
}
