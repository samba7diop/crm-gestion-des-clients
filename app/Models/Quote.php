<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Contact;
use App\Models\Invoice;

class Quote extends Model
{
    protected $fillable = [
        'contact_id',
        'lignes',
        'total_ht',
        'tva',
        'total_ttc',
        'statut',
        'signature_status',
        'signature_url',
        'date_validite',
    ];

    protected $casts = [
        'lignes' => 'array',
        'total_ht' => 'decimal:2',
        'tva' => 'decimal:2',
        'total_ttc' => 'decimal:2',
        'date_validite' => 'date',
    ];

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'quote_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'quote_id');
    }
}
