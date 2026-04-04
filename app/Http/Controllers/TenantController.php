<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('room')->latest()->get();
        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'vacant')->get();
        return view('tenants.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id'      => 'required|exists:rooms,id',
            'name'         => 'required|string|max:255',
            'phone'        => 'nullable|string|max:20',
            'national_id'  => 'nullable|string|max:50',
            'move_in_date' => 'required|date',
        ]);

        Tenant::create($request->all() + ['is_active' => true]);

        Room::find($request->room_id)->update(['status' => 'occupied']);

        return redirect()->route('tenants.index')
                         ->with('success', 'Tenant added successfully!');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->room->update(['status' => 'vacant']);
        $tenant->update(['is_active' => false, 'move_out_date' => now()]);

        return redirect()->route('tenants.index')
                         ->with('success', 'Tenant checked out.');
    }
}