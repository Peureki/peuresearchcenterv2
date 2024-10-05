<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'item_id',
        'user_id',
        'type',
    ];

    /*
        *
        *   FOREIGN KEYS
        *
    */
    public function item(){
        return $this->belongsTo(Items::class); 
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
