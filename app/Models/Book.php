<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'Book'; // Nom de la table (facultatif si la convention est respectée)

    protected $fillable = [
        'reference',
        'title',
        'niveau_academique',
        'type',
        'quantity',
        'price',
    ];
}
