<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Room;
use App\Models\Tenant;

class DashboardController extends Controller
{
    public function index()
    {
        $room           = Room::with('activeTenant')->first();
        $totalInvoices  = Invoice::count();
        $unpaidInvoices = Invoice::where('status', 'unpaid')->count();
        $paidInvoices   = Invoice::where('status', 'paid')->count();
        $totalCollected = Invoice::where('status', 'paid')->sum('total_usd');
        $totalPending   = Invoice::where('status', 'unpaid')->sum('total_usd');
        $recentInvoices = Invoice::with(['room', 'tenant'])
                            ->latest()->take(5)->get();

        return view('dashboard', compact(
            'room', 'totalInvoices', 'unpaidInvoices',
            'paidInvoices', 'totalCollected', 'totalPending', 'recentInvoices'
        ));
    }
}