@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> New Invoice
    </a>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card h-100" style="background: linear-gradient(135deg,#2563eb,#1d4ed8);">
            <div class="card-body text-white">
                <div class="fs-1 fw-bold">${{ number_format($totalCollected, 2) }}</div>
                <div class="opacity-75"><i class="bi bi-cash-stack me-1"></i>Collected</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100" style="background: linear-gradient(135deg,#dc2626,#b91c1c);">
            <div class="card-body text-white">
                <div class="fs-1 fw-bold">${{ number_format($totalPending, 2) }}</div>
                <div class="opacity-75"><i class="bi bi-hourglass-split me-1"></i>Pending</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100" style="background: linear-gradient(135deg,#16a34a,#15803d);">
            <div class="card-body text-white">
                <div class="fs-1 fw-bold">{{ $paidInvoices }}</div>
                <div class="opacity-75"><i class="bi bi-check-circle me-1"></i>Paid</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100" style="background: linear-gradient(135deg,#d97706,#b45309);">
            <div class="card-body text-white">
                <div class="fs-1 fw-bold">{{ $unpaidInvoices }}</div>
                <div class="opacity-75"><i class="bi bi-exclamation-circle me-1"></i>Unpaid</div>
            </div>
        </div>
    </div>
</div>

{{-- Room Card --}}
@if($room)
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-house-door me-2"></i>{{ $room->name }}
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="text-muted small">Status</div>
                <span class="badge bg-{{ $room->status === 'occupied' ? 'success' : 'secondary' }} mt-1">
                    {{ ucfirst($room->status) }}
                </span>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Current Tenant</div>
                <div class="fw-semibold">{{ $room->activeTenant?->name ?? '—' }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Monthly Rent</div>
                <div class="fw-semibold">${{ number_format($room->monthly_fee, 2) }}</div>
            </div>
            <div class="col-md-3">
                <div class="text-muted small">Rates</div>
                <div class="small">💧 {{ number_format($room->water_rate) }}៛/m³</div>
                <div class="small">⚡ {{ number_format($room->electric_rate) }}៛/kWh</div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Recent Invoices --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-receipt me-2"></i>Recent Invoices</span>
        <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Tenant</th>
                    <th>Total (USD)</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentInvoices as $inv)
                <tr>
                    <td class="fw-semibold">{{ $inv->month }}</td>
                    <td>{{ $inv->tenant->name }}</td>
                    <td class="fw-bold text-success">${{ number_format($inv->total_usd, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $inv->status === 'paid' ? 'success' : 'danger' }}">
                            {{ ucfirst($inv->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('invoices.show', $inv) }}"
                           class="btn btn-sm btn-outline-primary">
                           <i class="bi bi-eye"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>No invoices yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection