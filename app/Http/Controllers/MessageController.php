<?php

namespace App\Http\Controllers;

use App\Models\Room;
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
            'body' => ['required', 'string'],
        ]);

        $room->messages()->create([
            'body' => $validated['body'],
            'sender_id' => auth()->id(),
        ]);

        return back();
    }
}
