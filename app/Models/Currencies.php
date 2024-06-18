<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'description',
        'icon',
        'order',
        'value',
    ];

    // *
    // * RELATIONSHIPS
    // * 
    public function containerDropRate(){
        return $this->hasMany(ContainerDropRate::class); 
    }

}
