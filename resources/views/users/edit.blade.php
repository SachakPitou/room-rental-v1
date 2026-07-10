@extends('layouts.app')
@section('title','Edit User')
@section('content')

<div class="d-flex align-items-center mb-3 gap-2">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Edit User</h5>
</div>

{{-- User avatar header --}}
<div class="card mb-3">
<div class="card-body py-2">
    <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
             style="width:44px;height:44px;background:#1e293b;font-size:.95rem">
            {{ strtoupper(substr($user->name,0,2)) }}
        </div>
        <div>
            <div class="fw-semibold">{{ $user->name }}</div>
            <div class="text-muted small">{{ $user->email }}</div>
        </div>
        @if($user->id === auth()->id())
        <span class="ms-auto badge rounded-pill"
              style="background:#eff6ff;color:#1d4ed8">You</span>
        @endif
    </div>
</div>
</div>

{{-- Edit Info --}}
<div class="card mb-3">
    <div class="card-header">
        <i class="bi bi-person me-2"></i>Account Info
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold small">Full Name</label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold small">Email Address</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary w-100">
            <i class="bi bi-save me-1"></i>Save Changes
        </button>
        </form>
    </div>
</div>

{{-- Reset Password --}}
<div class="card mb-3">
    <div class="card-header">
        <i class="bi bi-shield-lock me-2"></i>Reset Password
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.reset-password', $user) }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold small">New Password</label>
            <div class="input-group">
                <input type="password" name="password" id="newPwd"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 8 characters" required>
                <span class="input-group-text" style="cursor:pointer"
                      onclick="togglePwd('newPwd','eye1')">
                    <i class="bi bi-eye" id="eye1"></i>
                </span>
            </div>
            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold small">Confirm New Password</label>
            <div class="input-group">
                <input type="password" name="password_confirmation" id="newPwd2"
                       class="form-control" placeholder="Repeat password" required>
                <span class="input-group-text" style="cursor:pointer"
                      onclick="togglePwd('newPwd2','eye2')">
                    <i class="bi bi-eye" id="eye2"></i>
                </span>
            </div>
        </div>

        <button class="btn btn-warning w-100">
            <i class="bi bi-key me-1"></i>Reset Password
        </button>
        </form>
    </div>
</div>

{{-- Danger Zone --}}
@if($user->id !== auth()->id())
<div class="card border-danger">
    <div class="card-header text-danger">
        <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">
            Permanently delete this user. This action cannot be undone.
        </p>
        <form method="POST" action="{{ route('users.destroy', $user) }}"
              onsubmit="return confirm('Delete {{ $user->name }} permanently?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger w-100">
                <i class="bi bi-trash me-1"></i>Delete User
            </button>
        </form>
    </div>
</div>
@endif

<script>
function togglePwd(inputId, iconId) {
    const el   = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (el.type === 'password') {
        el.type        = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        el.type        = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endsection