@extends('layouts.app')
@section('title','Add Tenant')
@section('content')

<div class="d-flex align-items-center mb-3 gap-2">
    <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Check In Tenant</h5>
</div>

<form method="POST" action="{{ route('tenants.store') }}">
@csrf

{{-- Room --}}
<div class="card mb-3">
    <div class="card-header">
        <i class="bi bi-house-door me-2"></i>Room Assignment
    </div>
    <div class="card-body">
        @if($rooms->isEmpty())
        <div class="alert alert-warning mb-0">
            <i class="bi bi-exclamation-triangle me-2"></i>No vacant rooms available.
        </div>
        @else
        <div class="mb-3">
            <label class="form-label fw-semibold small">Room</label>
            <select name="room_id" class="form-select" required>
                <option value="">-- Select Room --</option>
                @foreach($rooms as $room)
                <option value="{{ $room->id }}">
                    {{ $room->name }} — ${{ number_format($room->monthly_fee,2) }}/mo
                </option>
                @endforeach
            </select>
        </div>
        @endif
    </div>
</div>

@if(!$rooms->isEmpty())

{{-- Personal Info --}}
<div class="card mb-3">
    <div class="card-header">
        <i class="bi bi-person me-2"></i>Personal Information
    </div>
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control"
                   placeholder="e.g. Dara Sok"
                   value="{{ old('name') }}" required>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-6">
                <label class="form-label fw-semibold small">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control"
                       value="{{ old('date_of_birth') }}"
                       max="{{ date('Y-m-d') }}">
            </div>
            <div class="col-6">
                <label class="form-label fw-semibold small">Nationality</label>
                <input type="text" name="nationality" class="form-control"
                       placeholder="e.g. Cambodian"
                       value="{{ old('nationality') }}">
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-7">
                <label class="form-label fw-semibold small">Phone</label>
                <input type="text" name="phone" class="form-control"
                       placeholder="012 345 678"
                       value="{{ old('phone') }}">
            </div>
            <div class="col-5">
                <label class="form-label fw-semibold small">Country</label>
                <input type="text" name="country" class="form-control"
                       placeholder="e.g. Cambodia"
                       value="{{ old('country') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold small">National ID / Passport No.</label>
            <input type="text" name="national_id" class="form-control"
                   placeholder="e.g. 123456789"
                   value="{{ old('national_id') }}">
        </div>

        <div class="mb-0">
            <label class="form-label fw-semibold small">Birth Location (Full Address)</label>
            <textarea name="birth_location" class="form-control" rows="2"
                      placeholder="e.g. Village 3, Sangkat Ou Baek K'am, Khan Sen Sok, Phnom Penh">{{ old('birth_location') }}</textarea>
        </div>

    </div>
</div>

{{-- Check-in --}}
<div class="card mb-3">
    <div class="card-header">
        <i class="bi bi-box-arrow-in-right me-2 text-success"></i>Check-In Details
    </div>
    <div class="card-body">
        <div class="row g-2 mb-3">
            <div class="col-7">
                <label class="form-label fw-semibold small">Move In Date <span class="text-danger">*</span></label>
                <input type="date" name="move_in_date" class="form-control"
                       value="{{ old('move_in_date', date('Y-m-d')) }}" required>
            </div>
            <div class="col-5">
                <label class="form-label fw-semibold small">Time</label>
                <input type="time" name="check_in_time" class="form-control"
                       value="{{ old('check_in_time', date('H:i')) }}">
            </div>
        </div>
        <div>
            <label class="form-label fw-semibold small">Notes <span class="text-muted fw-normal">(optional)</span></label>
            <textarea name="notes" class="form-control" rows="2"
                      placeholder="e.g. Deposit paid, 2 keys given...">{{ old('notes') }}</textarea>
        </div>
    </div>
</div>

<div class="d-grid gap-2 mb-4">
    <button class="btn btn-success btn-lg">
        <i class="bi bi-box-arrow-in-right me-1"></i>Check In Tenant
    </button>
    <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>

@endif
</form>
@endsection