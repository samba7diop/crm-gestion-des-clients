<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Contact;
use App\Models\HistoryLog;
use App\Models\User;

class Opportunity extends Model
{
    protected $fillable = [
        'contact_id',
        'titre',
        'type',
        'valeur',
        'probabilite',
        'etape',
        'date_cloture',
        'commercial_id',
    ];

    protected $casts = [
        'valeur' => 'decimal:2',
        'probabilite' => 'integer',
        'date_cloture' => 'date',
    ];

    public function historyLogs()
    {
        return $this->morphMany(HistoryLog::class, 'model');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function commercial()
    {
        return $this->belongsTo(User::class, 'commercial_id');
    }
}
