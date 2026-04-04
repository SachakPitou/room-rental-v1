@extends('layouts.app')
@section('title', 'Add Tenant')
@section('content')

<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
    <div class="card-header"><i class="bi bi-person-plus me-2"></i>Add New Tenant</div>
    <div class="card-body">
        @if($rooms->isEmpty())
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                No vacant rooms available. All rooms are occupied.
            </div>
            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Back to Rooms</a>
        @else
        <form method="POST" action="{{ route('tenants.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Room</label>
                <select name="room_id" class="form-select" required>
                    <option value="">-- Select Room --</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->id }}">
                        {{ $room->name }} — ${{ $room->monthly_fee }}/mo
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" name="name" class="form-control"
                       placeholder="e.g. Dara Sok" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Phone Number</label>
                <input type="text" name="phone" class="form-control"
                       placeholder="e.g. 012 345 678" value="{{ old('phone') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">National ID (optional)</label>
                <input type="text" name="national_id" class="form-control"
                       value="{{ old('national_id') }}">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Move In Date</label>
                <input type="date" name="move_in_date" class="form-control"
                       value="{{ old('move_in_date', date('Y-m-d')) }}" required>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-primary">
                    <i class="bi bi-person-check me-1"></i>Add Tenant
                </button>
                <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
        @endif
    </div>
</div>
</div>
</div>

@endsection