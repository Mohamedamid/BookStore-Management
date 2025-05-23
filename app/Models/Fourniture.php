<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fourniture extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'name', 
        'quantity', 
        'price',
    ];
}
