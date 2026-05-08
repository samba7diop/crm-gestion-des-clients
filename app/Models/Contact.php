<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Activity;
use App\Models\HistoryLog;
use App\Models\Opportunity;
use App\Models\Quote;
use App\Models\User;

class Contact extends Model
{
    protected $fillable = [
        'nom',
        'entreprise',
        'email',
        'telephone',
        'source',
        'secteur',
        'taille',
        'score',
        'tags',
        'statut',
        'commercial_id',
    ];

    protected $casts = [
        'tags' => 'array',
        'score' => 'integer',
    ];

    public function commercial()
    {
        return $this->belongsTo(User::class, 'commercial_id');
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function historyLogs()
    {
        return $this->morphMany(HistoryLog::class, 'model');
    }
}
