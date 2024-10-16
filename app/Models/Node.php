<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'type',
        'sample_size',
    ];

    /*
     * RELATIONSHIPS
     */

     public function dropRate(){
        return $this->hasMany(NodeDropRate::class); 
    }
}
