<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Message;
use App\Models\UserSubuser;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function subusers()
    {
        return $this->belongsToMany(User::class,'user_subusers','user_id','sub_user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_role');
    }

    public function isSuperAdmin()
    {
        return $this->roles()->where('title','SuperAdmin')->count();
    }

    public function todaysubusers()
    {
        return $this->belongsToMany(User::class,'user_subusers','user_id','sub_user_id')->whereDate('users.created_at',date('Y-m-d'));
    }

    public function tasks()
    {
        return $this->hasMany(Task::class,'assigned_to');
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'from');
    }
}
