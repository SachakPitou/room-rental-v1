<?php
namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('activeTenant')->get();
        return view('rooms.index', compact('rooms'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'monthly_fee'     => 'required|numeric|min:0',
            'water_mode'      => 'required|in:metered,fixed',
            'water_rate'      => 'required_if:water_mode,metered|nullable|numeric|min:0',
            'water_fixed_fee' => 'required_if:water_mode,fixed|nullable|numeric|min:0',
            'electric_rate'   => 'required|numeric|min:0',
        ]);

        $room->update([
            'monthly_fee'     => $request->monthly_fee,
            'water_mode'      => $request->water_mode,
            'water_rate'      => $request->water_mode === 'metered' ? $request->water_rate : $room->water_rate,
            'water_fixed_fee' => $request->water_mode === 'fixed'   ? $request->water_fixed_fee : 0,
            'electric_rate'   => $request->electric_rate,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room updated!');
    }
}