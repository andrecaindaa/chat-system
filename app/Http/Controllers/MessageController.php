<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Room $room)
    {
        abort_unless(
            $room->users()->where('user_id', auth()->id())->exists(),
            403
        );

        $validated = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $message = $room->messages()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return back();
    }

    public function direct(User $user)
    {
        $authUser = auth()->user();

        $room = Room::where('type', 'direct')
            ->whereHas('users', fn ($q) => $q->where('user_id', $authUser->id))
            ->whereHas('users', fn ($q) => $q->where('user_id', $user->id))
            ->first();

        if (! $room) {
            $room = Room::create([
                'name' => $user->name,
                'type' => 'direct',
                'created_by' => $authUser->id,
            ]);

            $room->users()->attach([$authUser->id, $user->id]);
        }

        return redirect()->route('rooms.show', $room);
    }
}
