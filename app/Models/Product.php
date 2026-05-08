<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'prix_unitaire',
        'code',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
    ];
}
