<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'priority',
        'assigned_to',
        'assigned_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'assigned_to','id');
    }
}
