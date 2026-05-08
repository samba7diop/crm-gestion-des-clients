<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'api_token',
        'dashboard_preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'dashboard_preferences' => 'array',
    ];

    public function generateApiToken(): string
    {
        return $this->forceFill(['api_token' => bin2hex(random_bytes(40))])->api_token;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMarketing(): bool
    {
        return $this->role === 'marketing';
    }

    public function isCommercial(): bool
    {
        return $this->role === 'commercial';
    }

    public function isDirectorCommercial(): bool
    {
        return $this->role === 'directeur_commercial';
    }

    public function isAdministrationRole(): bool
    {
        return $this->role === 'administration';
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'admin' => 'Administrateur plateforme',
            'marketing' => 'Marketing',
            'commercial' => 'Commercial',
            'directeur_commercial' => 'Directeur Commercial',
            'administration' => 'Administration',
            default => ucfirst(str_replace('_', ' ', $this->role)),
        };
    }
}
