<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
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

    protected $casts = [
        'structure' => 'array',
        'views'     => 'integer',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
