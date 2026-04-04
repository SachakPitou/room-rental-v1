@extends('layouts.app')
@section('title', 'Invoice Detail')
@section('content')

<div class="row justify-content-center">
<div class="col-md-7">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0"><i class="bi bi-receipt me-2"></i>Invoice #{{ $invoice->id }}</h5>
    <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold fs-5">{{ $invoice->month }}</span>
        <span class="badge fs-6 bg-{{ $invoice->status === 'paid' ? 'success' : 'danger' }}">
            <i class="bi bi-{{ $invoice->status === 'paid' ? 'check-circle' : 'clock' }} me-1"></i>
            {{ strtoupper($invoice->status) }}
        </span>
    </div>

    <div class="card-body p-0">
        {{-- Info --}}
        <div class="row g-0 border-bottom p-3">
            <div class="col-6">
                <div class="text-muted small">Room</div>
                <div class="fw-semibold">{{ $invoice->room->name }}</div>
            </div>
            <div class="col-6">
                <div class="text-muted small">Tenant</div>
                <div class="fw-semibold">{{ $invoice->tenant->name }}</div>
            </div>
        </div>

        <table class="table table-borderless mb-0">
            {{-- Monthly Fee --}}
            <tr class="table-light">
                <td colspan="3" class="fw-semibold text-muted small py-2 px-3">🏠 MONTHLY RENT</td>
            </tr>
            <tr>
                <td class="ps-4">Room Fee</td>
                <td></td>
                <td class="text-end fw-semibold">${{ number_format($invoice->monthly_fee, 2) }}</td>
            </tr>

            {{-- Water --}}
            {{-- replace the water rows with this --}}
            <tr class="table-light">
                <td colspan="3" class="fw-semibold text-muted small py-2 px-3">💧 WATER</td>
            </tr>
            @if($invoice->water_mode === 'fixed')
            <tr>
                <td class="ps-4" colspan="2">Fixed fee (flat rate)</td>
                <td class="text-end fw-semibold">${{ number_format($invoice->water_fee_usd, 2) }}</td>
            </tr>
            @else
            <tr>
                <td class="ps-4 text-muted small">
                    {{ $invoice->prev_water }} → {{ $invoice->curr_water }} m³
                </td>
                <td class="text-muted small">
                    {{ $invoice->water_used }} m³ × {{ number_format($invoice->water_rate) }}៛
                    = {{ number_format($invoice->water_fee_riel) }}៛
                </td>
                <td class="text-end fw-semibold">${{ number_format($invoice->water_fee_usd, 2) }}</td>
            </tr>
            @endif

            {{-- Electric --}}
            <tr class="table-light">
                <td colspan="3" class="fw-semibold text-muted small py-2 px-3">⚡ ELECTRIC</td>
            </tr>
            <tr>
                <td class="ps-4 text-muted small">
                    {{ $invoice->prev_electric }} → {{ $invoice->curr_electric }} kWh
                </td>
                <td class="text-muted small">
                    {{ $invoice->electric_used }} kWh × {{ number_format($invoice->electric_rate) }}៛
                    = {{ number_format($invoice->electric_fee_riel) }}៛
                </td>
                <td class="text-end fw-semibold">${{ number_format($invoice->electric_fee_usd, 2) }}</td>
            </tr>

            {{-- Extra --}}
            @if($invoice->extra_fee > 0)
            <tr class="table-light">
                <td colspan="3" class="fw-semibold text-muted small py-2 px-3">➕ EXTRA</td>
            </tr>
            <tr>
                <td class="ps-4" colspan="2">{{ $invoice->extra_fee_note ?? 'Extra Fee' }}</td>
                <td class="text-end fw-semibold">${{ number_format($invoice->extra_fee, 2) }}</td>
            </tr>
            @endif

            {{-- Total --}}
            <tr class="border-top">
                <td colspan="2" class="fw-bold fs-5 ps-3">TOTAL</td>
                <td class="text-end fw-bold fs-4 text-success pe-3">
                    ${{ number_format($invoice->total_usd, 2) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-muted small ps-3 pb-2">
                    Exchange rate: $1 = {{ number_format($invoice->exchange_rate) }}៛
                </td>
            </tr>
        </table>
    </div>

    @if($invoice->status === 'unpaid')
    <div class="card-footer bg-white pt-0 pb-3 px-3">
        <form method="POST" action="{{ route('invoices.paid', $invoice) }}">
            @csrf @method('PATCH')
            <button class="btn btn-success w-100 btn-lg">
                <i class="bi bi-check-circle me-1"></i>Mark as Paid
            </button>
        </form>
    </div>
    @else
    <div class="card-footer bg-white">
        <div class="alert alert-success mb-0 text-center">
            <i class="bi bi-check-circle-fill me-2"></i>
            Paid on {{ $invoice->paid_date?->format('d M Y') }}
        </div>
    </div>
    @endif
</div>

</div>
</div>

@endsection