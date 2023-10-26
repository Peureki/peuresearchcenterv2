<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sample_size',
    ];
}
