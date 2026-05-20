<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Workspace extends Model
{
    // Database columns for input.
    protected $fillable = ['user_id', 'name', 'slug'];

    // Auto-generate unique slug on creation.
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($workspace) {
            if (empty($workspace->slug)) {
                $workspace->slug = Str::slug($workspace->name) . '-' . Str::random(5);
            }
        });
    }

    // Link to owner.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Link to related presentations.
    public function presentations()
    {
        return $this->hasMany(Presentation::class);
    }
}
