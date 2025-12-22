<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Services\RoomService;
use App\Repositories\RoomRepository;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct(
        protected RoomService $roomService,
        protected RoomRepository $roomRepository
    ) {
        $this->authorizeResource(Room::class, 'room');
    }

    public function index(Request $request)
    {
        $rooms = $this->roomRepository->paginate(
            10,
            $request->only(['search', 'is_active'])
        );

        return view('dashboard.room.index', compact('rooms'));
    }

    public function create()
    {
        return view('dashboard.room.create');
    }


    public function store(StoreRoomRequest $request)
    {
        $this->roomService->create($request->validated());
        return back()->with('success', 'Room created');
    }

    public function edit(Room $room)
    {
        return view('dashboard.room.edit', compact('room'));
    }

    public function show(Room $room)
    {
        return view('dashboard.room.show', compact('room'));
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $this->roomService->update($room, $request->validated());
        return back()->with('success', 'Room updated');
    }

    public function destroy(Room $room)
    {
        $this->roomService->delete($room);
        return back()->with('success', 'Room deleted');
    }
}
