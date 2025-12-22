<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'content',
    ];

    /**
     * Autor da mensagem
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sala da mensagem
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
