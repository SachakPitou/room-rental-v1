@extends('layouts.app')
@section('title','Change Password')
@section('content')

<div class="d-flex align-items-center mb-3 gap-2">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Change Password</h5>
</div>

<div class="row justify-content-center">
<div class="col-md-5">
<div class="card">
    <div class="card-body">

        <div class="text-center mb-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                 style="width:56px;height:56px;background:#1e293b">
                <i class="bi bi-shield-lock text-white fs-5"></i>
            </div>
            <div class="fw-semibold">{{ auth()->user()->name }}</div>
            <div class="text-muted small">{{ auth()->user()->email }}</div>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold small">Current Password</label>
            <input type="password" name="current_password"
                   class="form-control @error('current_password') is-invalid @enderror"
                   placeholder="••••••••" required>
            @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold small">New Password</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Min. 8 characters" required>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold small">Confirm New Password</label>
            <input type="password" name="password_confirmation"
                   class="form-control" placeholder="Repeat new password" required>
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary">
                <i class="bi bi-shield-check me-1"></i>Update Password
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>

        </form>
    </div>
</div>
</div>
</div>
@endsection