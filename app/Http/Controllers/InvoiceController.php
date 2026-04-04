<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Room;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['room', 'tenant'])->latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $rooms = Room::with('activeTenant')
                     ->where('status', 'occupied')->get();
        // get last invoice to pre-fill meter readings
        $lastInvoice = Invoice::latest()->first();
        return view('invoices.create', compact('rooms', 'lastInvoice'));
    }

    public function store(Request $request)
    {
        $rules = [
            'room_id'       => 'required|exists:rooms,id',
            'tenant_id'     => 'required|exists:tenants,id',
            'month'         => 'required',
            'prev_electric' => 'required|numeric|min:0',
            'curr_electric' => 'required|numeric|gte:prev_electric',
            'extra_fee'     => 'nullable|numeric|min:0',
            'exchange_rate' => 'required|numeric|min:1',
        ];

        $room = Room::findOrFail($request->room_id);

        // Only validate water meter if metered mode
        if ($room->isFixedWater()) {
            $rules['prev_water'] = 'nullable';
            $rules['curr_water'] = 'nullable';
        } else {
            $rules['prev_water'] = 'required|numeric|min:0';
            $rules['curr_water'] = 'required|numeric|gte:prev_water';
        }

        $request->validate($rules);

        $exchangeRate    = $request->exchange_rate;
        $electricUsed    = $request->curr_electric - $request->prev_electric;
        $electricFeeRiel = $electricUsed * $room->electric_rate;
        $electricFeeUsd  = $electricFeeRiel / $exchangeRate;

        // Water calculation: fixed or metered
        if ($room->isFixedWater()) {
            $waterUsed      = 0;
            $waterFeeRiel   = 0;
            $waterFeeUsd    = $room->water_fixed_fee; // flat USD fee
            $prevWater      = null;
            $currWater      = null;
        } else {
            $waterUsed      = $request->curr_water - $request->prev_water;
            $waterFeeRiel   = $waterUsed * $room->water_rate;
            $waterFeeUsd    = $waterFeeRiel / $exchangeRate;
            $prevWater      = $request->prev_water;
            $currWater      = $request->curr_water;
        }

        $extraFee = $request->extra_fee ?? 0;
        $total    = $room->monthly_fee + $waterFeeUsd + $electricFeeUsd + $extraFee;

        Invoice::create([
            'room_id'           => $room->id,
            'tenant_id'         => $request->tenant_id,
            'month'             => $request->month,
            'monthly_fee'       => $room->monthly_fee,
            'prev_water'        => $prevWater,
            'curr_water'        => $currWater,
            'water_rate'        => $room->water_rate,
            'water_used'        => $waterUsed,
            'water_fee_riel'    => $waterFeeRiel,
            'water_fee_usd'     => round($waterFeeUsd, 2),
            'water_mode'        => $room->water_mode,
            'water_fixed_fee'   => $room->water_fixed_fee,
            'prev_electric'     => $request->prev_electric,
            'curr_electric'     => $request->curr_electric,
            'electric_rate'     => $room->electric_rate,
            'electric_used'     => $electricUsed,
            'electric_fee_riel' => $electricFeeRiel,
            'electric_fee_usd'  => round($electricFeeUsd, 2),
            'extra_fee'         => $extraFee,
            'extra_fee_note'    => $request->extra_fee_note,
            'exchange_rate'     => $exchangeRate,
            'total_usd'         => round($total, 2),
            'status'            => 'unpaid',
        ]);

        return redirect()->route('invoices.index')->with('success', 'Invoice created!');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function markPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid', 'paid_date' => now()]);
        return back()->with('success', 'Invoice marked as paid! ✅');
    }
}