@extends('layouts.app')
@section('title','Add Tenant')
@section('content')

<div class="d-flex align-items-center mb-3 gap-2">
    <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Check In Tenant</h5>
</div>

<div class="card">
<div class="card-body">
@if($rooms->isEmpty())
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle me-2"></i>
        No vacant rooms available.
    </div>
@else
<form method="POST" action="{{ route('tenants.store') }}">
@csrf

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

<div class="mb-3">
    <label class="form-label fw-semibold small">Full Name</label>
    <input type="text" name="name" class="form-control"
           placeholder="e.g. Dara Sok" value="{{ old('name') }}" required>
</div>

<div class="row g-2 mb-3">
    <div class="col-7">
        <label class="form-label fw-semibold small">Phone</label>
        <input type="text" name="phone" class="form-control"
               placeholder="012 345 678" value="{{ old('phone') }}">
    </div>
    <div class="col-5">
        <label class="form-label fw-semibold small">National ID</label>
        <input type="text" name="national_id" class="form-control" value="{{ old('national_id') }}">
    </div>
</div>

{{-- Check-in date + time --}}
<div class="rounded-3 p-3 mb-3" style="background:#dcfce7; border:1px solid #86efac">
    <div class="fw-semibold small mb-2" style="color:#15803d">
        <i class="bi bi-box-arrow-in-right me-1"></i>Check-In
    </div>
    <div class="row g-2">
        <div class="col-7">
            <label class="form-label" style="font-size:.72rem">Date</label>
            <input type="date" name="move_in_date" class="form-control form-control-sm"
                   value="{{ old('move_in_date', date('Y-m-d')) }}" required>
        </div>
        <div class="col-5">
            <label class="form-label" style="font-size:.72rem">Time (optional)</label>
            <input type="time" name="check_in_time" class="form-control form-control-sm"
                   value="{{ old('check_in_time', date('H:i')) }}">
        </div>
    </div>
</div>

<div class="mb-4">
    <label class="form-label fw-semibold small">Notes <span class="text-muted fw-normal">(optional)</span></label>
    <textarea name="notes" class="form-control" rows="2"
              placeholder="e.g. Deposit paid, 2 keys given...">{{ old('notes') }}</textarea>
</div>

<div class="d-grid gap-2">
    <button class="btn btn-success">
        <i class="bi bi-box-arrow-in-right me-1"></i>Check In
    </button>
    <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>

</form>
@endif
</div>
</div>
@endsection