<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeItem extends Model
{
    protected $fillable = ['commande_id', 'barcode', 'name', 'quantity', 'price', 'discount'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}

