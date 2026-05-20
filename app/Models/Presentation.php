<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'topic',
        'structure'
    ];

    protected $casts = [
        'structure' => 'array'
    ];
}
