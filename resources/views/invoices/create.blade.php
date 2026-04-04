@extends('layouts.app')
@section('title', 'New Invoice')
@section('content')

<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
    <div class="card-header"><i class="bi bi-receipt me-2"></i>Create Invoice</div>
    <div class="card-body">

        @if($rooms->isEmpty())
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                No occupied rooms. Please <a href="{{ route('tenants.create') }}">add a tenant</a> first.
            </div>
        @else
        <form method="POST" action="{{ route('invoices.store') }}">
        @csrf

        {{-- Room --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Room & Tenant</label>
            <select name="room_id" class="form-select" id="roomSelect" required>
                <option value="">-- Select Room --</option>
                @foreach($rooms as $room)
                <option value="{{ $room->id }}"
                    data-tenant-id="{{ $room->activeTenant?->id }}"
                    data-tenant-name="{{ $room->activeTenant?->name }}">
                    {{ $room->name }} — {{ $room->activeTenant?->name ?? 'No Tenant' }}
                </option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="tenant_id" id="tenantId">

        {{-- Month + Exchange Rate --}}
        <div class="row mb-3">
            <div class="col">
                <label class="form-label fw-semibold">Billing Month</label>
                <input type="month" name="month" class="form-control"
                       value="{{ date('Y-m') }}" required>
            </div>
            <div class="col">
                <label class="form-label fw-semibold">Exchange Rate (៛ per $1)</label>
                <div class="input-group">
                    <input type="number" name="exchange_rate" class="form-control"
                           value="4100" required>
                    <span class="input-group-text">៛</span>
                </div>
            </div>
        </div>

        {{-- Water (dynamic based on room mode) --}}
        <div id="waterMetered" class="card bg-light border-0 mb-3 p-3">
            <div class="fw-semibold mb-2">💧 Water Meter (m³)</div>
            <div class="row g-2">
                <div class="col">
                    <label class="form-label small">Previous Reading</label>
                    <input type="number" step="0.01" name="prev_water" class="form-control"
                        value="{{ $lastInvoice?->curr_water ?? 0 }}">
                </div>
                <div class="col">
                    <label class="form-label small">Current Reading</label>
                    <input type="number" step="0.01" name="curr_water"
                        class="form-control" id="currWater">
                </div>
                <div class="col-auto d-flex align-items-end">
                    <div class="bg-white border rounded px-3 py-2 text-info fw-bold" id="waterUsed">
                        0 m³
                    </div>
                </div>
            </div>
        </div>

        <div id="waterFixed" class="card border-info border-0 bg-light mb-3 p-3" style="display:none">
            <div class="fw-semibold mb-1">💧 Water — Fixed Fee</div>
            <div class="text-muted small" id="fixedWaterNote">Flat fee applied automatically.</div>
        </div>

        {{-- Electric --}}
        <div class="card bg-light border-0 mb-3 p-3">
            <div class="fw-semibold mb-2">⚡ Electric Meter (kWh)</div>
            <div class="row g-2">
                <div class="col">
                    <label class="form-label small">Previous Reading</label>
                    <input type="number" step="0.01" name="prev_electric" class="form-control"
                           value="{{ $lastInvoice?->curr_electric ?? 0 }}" required>
                </div>
                <div class="col">
                    <label class="form-label small">Current Reading</label>
                    <input type="number" step="0.01" name="curr_electric"
                           class="form-control" id="currElectric" required>
                </div>
                <div class="col-auto d-flex align-items-end">
                    <div class="bg-white border rounded px-3 py-2 text-warning fw-bold" id="electricUsed">
                        0 kWh
                    </div>
                </div>
            </div>
        </div>

        {{-- Extra Fee --}}
        <div class="row mb-4">
            <div class="col">
                <label class="form-label fw-semibold">Extra Fee (USD)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="extra_fee"
                           class="form-control" value="0">
                </div>
            </div>
            <div class="col">
                <label class="form-label fw-semibold">Note</label>
                <input type="text" name="extra_fee_note" class="form-control"
                       placeholder="e.g. Trash, Internet...">
            </div>
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary btn-lg">
                <i class="bi bi-file-earmark-check me-1"></i>Generate Invoice
            </button>
            <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>

        </form>
        @endif
    </div>
</div>
</div>
</div>

<script>
// Pass room water mode data from server
const roomData = {
    @foreach($rooms as $room)
    "{{ $room->id }}": {
        tenantId:       "{{ $room->activeTenant?->id }}",
        waterMode:      "{{ $room->water_mode }}",
        waterFixedFee:  "{{ $room->water_fixed_fee }}",
    },
    @endforeach
};

document.getElementById('roomSelect').addEventListener('change', function () {
    const data = roomData[this.value];
    if (!data) return;

    document.getElementById('tenantId').value = data.tenantId;

    const isFixed = data.waterMode === 'fixed';
    document.getElementById('waterMetered').style.display = isFixed ? 'none' : 'block';
    document.getElementById('waterFixed').style.display   = isFixed ? 'block' : 'none';
    if (isFixed) {
        document.getElementById('fixedWaterNote').textContent =
            `Fixed water fee: $${parseFloat(data.waterFixedFee).toFixed(2)}/month (applied automatically)`;
    }
});

function updateUsage() {
    const prevW = parseFloat(document.querySelector('[name=prev_water]').value) || 0;
    const currW = parseFloat(document.getElementById('currWater').value)        || 0;
    const prevE = parseFloat(document.querySelector('[name=prev_electric]').value) || 0;
    const currE = parseFloat(document.getElementById('currElectric').value)        || 0;
    document.getElementById('waterUsed').textContent    = Math.max(0, currW - prevW).toFixed(2) + ' m³';
    document.getElementById('electricUsed').textContent = Math.max(0, currE - prevE).toFixed(2) + ' kWh';
}
document.querySelectorAll('input[type=number]').forEach(el => el.addEventListener('input', updateUsage));
</script>

@endsection