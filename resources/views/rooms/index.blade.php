@extends('layouts.app')
@section('title', 'Room')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-house-door me-2"></i>Room Settings</h4>
</div>

@foreach($rooms as $room)
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>{{ $room->name }}</span>
        <span class="badge bg-{{ $room->status === 'occupied' ? 'success' : 'secondary' }}">
            {{ ucfirst($room->status) }}
        </span>
    </div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="text-muted small">Monthly Rent</div>
                <div class="fs-5 fw-bold text-primary">${{ number_format($room->monthly_fee, 2) }}</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Water Rate</div>
                <div class="fs-5 fw-bold text-info">{{ number_format($room->water_rate) }} ៛/m³</div>
            </div>
            <div class="col-md-4">
                <div class="text-muted small">Electric Rate</div>
                <div class="fs-5 fw-bold text-warning">{{ number_format($room->electric_rate) }} ៛/kWh</div>
            </div>
        </div>
        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil me-1"></i>Edit Rates
        </a>
    </div>
</div>
@endforeach

@endsection