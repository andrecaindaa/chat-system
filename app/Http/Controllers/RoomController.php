<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    /**
     * Listar salas do utilizador
     */
    public function index(Request $request)
    {
        $rooms = $request->user()
            ->rooms()
            ->with('owner')
            ->orderBy('name')
            ->get();

        return Inertia::render('Rooms/Index', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * Criar uma nova sala
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);

    $room = Room::create([
        'name' => $validated['name'],
        'created_by' => $request->user()->id,
    ]);

    // Criador entra como ADMIN
    $room->users()->attach($request->user()->id, [
        'role' => 'admin',
    ]);

    return redirect()->route('rooms.show', $room);
}


  public function show(Room $room)
{
    abort_unless(
        $room->users()->where('user_id', auth()->id())->exists(),
        403
    );

    // marca como lida
    $room->users()->updateExistingPivot(auth()->id(), [
        'last_read_at' => now(),
    ]);

    $room->load([
        'users:id,name,profile_photo_path',
        'messages.user:id,name,profile_photo_path',
    ]);

    return Inertia::render('Rooms/Show', [
        'room' => $room,
    ]);
}


    public function invite(Request $request, Room $room)
    {
        abort_unless($room->created_by === auth()->id(), 403);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $room->users()->syncWithoutDetaching($validated['user_id']);

        return back();
    }

}
