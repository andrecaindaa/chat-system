<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar',
        'created_by',
    ];

    /**
     * Dono da sala
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isOwner(User $user)
    {
        return $this->created_by === $user->id;
    }


    /**
     * Utilizadores da sala
     */
    public function users()
{
    return $this->belongsToMany(User::class)
        ->withPivot(['role', 'last_read_at'])
        ->withTimestamps();
}

    public function admins()
    {
        return $this->users()->wherePivot('role', 'admin');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function unreadCountFor(User $user): int
    {
        $pivot = $this->users()
            ->where('user_id', $user->id)
            ->first()
            ->pivot;


        if (! $pivot->last_read_at) {
            return $this->messages()->count();
        }

        return $this->messages()
            ->where('created_at', '>', $pivot->last_read_at)
            ->count();
    }

    public function displayNameFor(User $user): string
{
    // Salas normais
    if ($this->type === 'group') {
        return $this->name;
    }

    // DM → mostrar o outro utilizador
    $otherUser = $this->users
        ->firstWhere('id', '!=', $user->id);

    return $otherUser?->name ?? 'Mensagem direta';
}

}
