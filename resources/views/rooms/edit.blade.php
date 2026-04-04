@extends('layouts.app')
@section('title', 'Edit Room')
@section('content')

<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
    <div class="card-header"><i class="bi bi-pencil me-2"></i>Edit {{ $room->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('rooms.update', $room) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Monthly Rent (USD)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="monthly_fee"
                           class="form-control" value="{{ $room->monthly_fee }}" required>
                </div>
            </div>

            {{-- Water Mode Toggle --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">💧 Water Billing Mode</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="water_mode"
                               id="modeMetered" value="metered"
                               {{ $room->water_mode === 'metered' ? 'checked' : '' }}
                               onchange="toggleWaterMode()">
                        <label class="form-check-label" for="modeMetered">
                            📊 Metered (per m³)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="water_mode"
                               id="modeFixed" value="fixed"
                               {{ $room->water_mode === 'fixed' ? 'checked' : '' }}
                               onchange="toggleWaterMode()">
                        <label class="form-check-label" for="modeFixed">
                            📌 Fixed Fee (flat/month)
                        </label>
                    </div>
                </div>
            </div>

            {{-- Metered section --}}
            <div id="meteredSection" class="mb-3">
                <label class="form-label fw-semibold">Water Rate (Riel per m³)</label>
                <div class="input-group">
                    <input type="number" step="0.01" name="water_rate"
                           class="form-control" value="{{ $room->water_rate }}">
                    <span class="input-group-text">៛/m³</span>
                </div>
            </div>

            {{-- Fixed section --}}
            <div id="fixedSection" class="mb-3" style="display:none">
                <label class="form-label fw-semibold">Fixed Water Fee (USD/month)</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="water_fixed_fee"
                           class="form-control" value="{{ $room->water_fixed_fee }}">
                    <span class="input-group-text">/ month</span>
                </div>
                <div class="form-text text-muted">Tenant pays this flat amount regardless of usage.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">⚡ Electric Rate (Riel per kWh)</label>
                <div class="input-group">
                    <input type="number" step="0.01" name="electric_rate"
                           class="form-control" value="{{ $room->electric_rate }}" required>
                    <span class="input-group-text">៛/kWh</span>
                </div>
            </div>

            {{-- Summary preview --}}
            <div class="alert alert-info small mb-4">
                <i class="bi bi-info-circle me-1"></i>
                <strong>Note:</strong> Changing rates only affects <u>new invoices</u>.
                Existing invoices keep their original rates.
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Save Changes
                </button>
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<script>
function toggleWaterMode() {
    const isFixed = document.getElementById('modeFixed').checked;
    document.getElementById('meteredSection').style.display = isFixed ? 'none' : 'block';
    document.getElementById('fixedSection').style.display   = isFixed ? 'block' : 'none';
}
// Run on page load
toggleWaterMode();
</script>

@endsection