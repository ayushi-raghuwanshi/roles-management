<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['from', 'to', 'message', 'is_read'];

    /**
     * Get the user who sent this message
     */
    public function senderuser()
    {
        return $this->belongsTo(User::class,'from');
    }

    /**
     * Get the user who received this message
     */
    public function recieveruser()
    {
        return $this->belongsTo(User::class,'to');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'from');
    }
}
