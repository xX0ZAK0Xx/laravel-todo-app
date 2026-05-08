<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'is_done', 'priority', 'due_date'];
    protected $casts = [
        'is_done' => 'boolean',
        'due_date' => 'datetime',
    ];
}
