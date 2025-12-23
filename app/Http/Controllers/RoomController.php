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

        // adiciona o criador à sala
        $room->users()->attach($request->user()->id);

        return redirect()->route('rooms.index');
    }

    public function show(Room $room)
{
    // Segurança: só membros podem aceder
    abort_unless(
        $room->users()->where('user_id', auth()->id())->exists(),
        403
    );

    $room->load([
        'users:id,name,profile_photo_path',
        'messages.sender:id,name,profile_photo_path',
    ]);

    return Inertia::render('Rooms/Show', [
        'room' => $room,
    ]);
}
}
