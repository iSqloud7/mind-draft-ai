<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Allowed input fields.
    protected $fillable = ['name', 'email', 'password'];

    // Fields hidden from API responses.
    protected $hidden = ['password', 'remember_token'];

    // Data type formatting.
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // User's owned workspaces.
    public function workspaces()
    {
        return $this->hasMany(Workspace::class);
    }

    // User's created presentations.
    public function presentations()
    {
        return $this->hasMany(Presentation::class);
    }
}
