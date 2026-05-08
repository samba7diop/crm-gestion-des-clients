<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Contact;
use App\Models\User;

class Activity extends Model
{
    protected $fillable = [
        'contact_id',
        'type',
        'description',
        'date',
        'commercial_id',
        'resultat',
        'rappel',
    ];

    protected $casts = [
        'date' => 'datetime',
        'rappel' => 'boolean',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function commercial()
    {
        return $this->belongsTo(User::class, 'commercial_id');
    }
}
