<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function taskLists()
    {
        return $this->hasMany(TaskList::class);
    }

    public function sharedTaskLists()
    {
        return $this->belongsToMany(TaskList::class, 'task_list_user', 'user_id', 'task_list_id')
            ->withPivot('permission')
            ->withTimestamps();
    }
}
