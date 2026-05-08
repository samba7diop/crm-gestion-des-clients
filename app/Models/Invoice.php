<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Quote;

class Invoice extends Model
{
    protected $fillable = [
        'quote_id',
        'numero',
        'montant',
        'date_echeance',
        'statut_paiement',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_echeance' => 'date',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }
}
