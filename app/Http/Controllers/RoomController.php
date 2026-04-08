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

    public function show(Room $room)
    {
        $room->load([
            'tenants' => function($q) {
                $q->orderByDesc('move_in_date');
            },
            'tenants.invoices',
            'activeTenant',
            'invoices' => function($q) {
                $q->latest()->take(5);
            },
        ]);

        // Stats
        $totalTenants   = $room->tenants->count();
        $totalIncome    = $room->invoices()->where('status','paid')->sum('total_usd');
        $pendingIncome  = $room->invoices()->where('status','unpaid')->sum('total_usd');
        $totalInvoices  = $room->invoices()->count();

        return view('rooms.show', compact(
            'room', 'totalTenants', 'totalIncome',
            'pendingIncome', 'totalInvoices'
        ));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:100|unique:rooms,name',
            'monthly_fee'     => 'required|numeric|min:0',
            'water_mode'      => 'required|in:metered,fixed',
            'water_rate'      => 'nullable|numeric|min:0',
            'water_fixed_fee' => 'nullable|numeric|min:0',
            'electric_rate'   => 'required|numeric|min:0',
        ]);

        Room::create([
            'name'            => $request->name,
            'monthly_fee'     => $request->monthly_fee,
            'water_mode'      => $request->water_mode,
            'water_rate'      => $request->water_mode === 'metered' ? $request->water_rate : 0,
            'water_fixed_fee' => $request->water_mode === 'fixed'   ? $request->water_fixed_fee : 0,
            'electric_rate'   => $request->electric_rate,
            'status'          => 'vacant',
        ]);

        return redirect()->route('rooms.index')
                         ->with('success', 'Room added successfully!');
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
            'water_rate'      => 'nullable|numeric|min:0',
            'water_fixed_fee' => 'nullable|numeric|min:0',
            'electric_rate'   => 'required|numeric|min:0',
        ]);

        $room->update([
            'monthly_fee'     => $request->monthly_fee,
            'water_mode'      => $request->water_mode,
            'water_rate'      => $request->water_mode === 'metered' ? $request->water_rate : $room->water_rate,
            'water_fixed_fee' => $request->water_mode === 'fixed'   ? $request->water_fixed_fee : 0,
            'electric_rate'   => $request->electric_rate,
        ]);

        return redirect()->route('rooms.index')
                         ->with('success', 'Room updated!');
    }

    public function destroy(Room $room)
    {
        if ($room->status === 'occupied') {
            return back()->with('error', 'Cannot delete an occupied room.');
        }
        $room->delete();
        return redirect()->route('rooms.index')
                         ->with('success', 'Room deleted.');
    }
}