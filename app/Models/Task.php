<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'is_completed', 'due_date', 'due_time'];

    protected $casts = ['is_completed' => 'boolean', 'due_date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
