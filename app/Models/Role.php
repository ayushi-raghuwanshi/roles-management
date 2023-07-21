<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $table = 'roles';
    protected $fillable = [
        'title',
        'created_at',
        'updated_at',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_permission');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_role');
    }
}
