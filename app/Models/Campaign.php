<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'nom',
        'type',
        'template_id',
        'destinataires',
        'date_envoi',
        'stats',
        'statut',
    ];

    protected $casts = [
        'destinataires' => 'array',
        'date_envoi' => 'datetime',
        'stats' => 'array',
    ];
}
