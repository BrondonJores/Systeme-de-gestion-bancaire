<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //Un client peut avoir plusieurs comptes : relation hasMany
    public function comptebancaire() {
        return $this->hasMany(CompteBancaire::class);
    }

    //Acteur de la platerforme Client, conseille, administrateur
    public function isAdmin() {
        return $this->role === 'admin';
    }
    public function isClient() {
        return $this->role === 'client';
    }
    public function isConseiller() {
        return $this->role === 'conseiller';
    }

    public function canAccessAdminPanel(): bool
    {
        return $this->isAdmin();
    }

    public function canAccessClientPanel(): bool
    {
        return $this->isClient();
    }

    public function canAccessConseillerPanel(): bool
    {
        return $this->isConseiller();
    }

}
