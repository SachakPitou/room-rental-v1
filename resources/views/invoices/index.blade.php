@extends('layouts.app')
@section('title', 'Invoices')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-receipt me-2"></i>Invoices</h4>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>New Invoice
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Month</th>
                    <th>Tenant</th>
                    <th>Room Fee</th>
                    <th>Water</th>
                    <th>Electric</th>
                    <th>Extra</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                <tr>
                    <td class="text-muted small">{{ $inv->id }}</td>
                    <td class="fw-semibold">{{ $inv->month }}</td>
                    <td>{{ $inv->tenant->name }}</td>
                    <td>${{ number_format($inv->monthly_fee, 2) }}</td>
                    <td>${{ number_format($inv->water_fee_usd, 2) }}</td>
                    <td>${{ number_format($inv->electric_fee_usd, 2) }}</td>
                    <td>${{ number_format($inv->extra_fee, 2) }}</td>
                    <td class="fw-bold text-success">${{ number_format($inv->total_usd, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $inv->status === 'paid' ? 'success' : 'danger' }}">
                            {{ ucfirst($inv->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('invoices.show', $inv) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-4">
                        <i class="bi bi-receipt fs-3 d-block mb-2"></i>No invoices yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection