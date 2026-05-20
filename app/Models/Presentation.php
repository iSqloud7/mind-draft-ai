<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    // List of database columns allowed for saving.
    protected $fillable = [
        'user_id',
        'workspace_id',
        'title',
        'topic',
        'structure',
        'share_token',
        'views',
        'ai_model',
        'ai_temperature',
    ];

    // Cast attributes to specific data types.
    protected $casts = [
        'structure' => 'array',
        'views' => 'integer',
    ];

    // Relationship: Presentation belongs to a Workspace.
    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    // Relationship: Presentation belongs to a User.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
