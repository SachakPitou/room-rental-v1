<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        // Active tenants first, then by move-in date
        $tenants = Tenant::with('room')
                         ->orderByDesc('is_active')
                         ->orderByDesc('move_in_date')
                         ->get();
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
            'room_id'       => 'required|exists:rooms,id',
            'name'          => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'national_id'   => 'nullable|string|max:50',
            'move_in_date'  => 'required|date',
            'check_in_time' => 'nullable|date_format:H:i',
            'notes'         => 'nullable|string|max:500',
        ]);

        Tenant::create([
            'room_id'       => $request->room_id,
            'name'          => $request->name,
            'phone'         => $request->phone,
            'national_id'   => $request->national_id,
            'move_in_date'  => $request->move_in_date,
            'check_in_time' => $request->check_in_time,
            'notes'         => $request->notes,
            'is_active'     => true,
        ]);

        Room::find($request->room_id)->update(['status' => 'occupied']);

        return redirect()->route('tenants.index')
                         ->with('success', 'Tenant checked in successfully!');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load('room', 'invoices');
        return view('tenants.show', compact('tenant'));
    }

    // Show checkout form
    public function editCheckout(Tenant $tenant)
    {
        return view('tenants.checkout', compact('tenant'));
    }

    // Process checkout
    public function checkout(Request $request, Tenant $tenant)
    {
        $request->validate([
            'move_out_date'  => 'required|date|after_or_equal:' . $tenant->move_in_date->format('Y-m-d'),
            'check_out_time' => 'nullable|date_format:H:i',
            'notes'          => 'nullable|string|max:500',
        ]);

        $tenant->update([
            'move_out_date'  => $request->move_out_date,
            'check_out_time' => $request->check_out_time,
            'notes'          => $request->notes ?? $tenant->notes,
            'is_active'      => false,
        ]);

        $tenant->room->update(['status' => 'vacant']);

        return redirect()->route('tenants.index')
                         ->with('success', $tenant->name . ' checked out successfully!');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->room->update(['status' => 'vacant']);
        $tenant->delete();
        return redirect()->route('tenants.index')
                         ->with('success', 'Tenant deleted.');
    }
}