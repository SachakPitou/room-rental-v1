@extends('layouts.app')
@section('title','Add User')
@section('content')

<div class="d-flex align-items-center mb-3 gap-2">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0">Add New User</h5>
</div>

<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
<div class="card-body">
<form method="POST" action="{{ route('users.store') }}">
@csrf

<div class="mb-3">
    <label class="form-label fw-semibold small">Full Name</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           placeholder="e.g. Dara Admin"
           value="{{ old('name') }}" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold small">Email Address</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
           placeholder="e.g. dara@roomrental.com"
           value="{{ old('email') }}" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold small">Password</label>
    <div class="input-group">
        <input type="password" name="password" id="pwd"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="Min. 8 characters" required>
        <span class="input-group-text" style="cursor:pointer" onclick="togglePwd('pwd','eye1')">
            <i class="bi bi-eye" id="eye1"></i>
        </span>
    </div>
    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
    <label class="form-label fw-semibold small">Confirm Password</label>
    <div class="input-group">
        <input type="password" name="password_confirmation" id="pwd2"
               class="form-control" placeholder="Repeat password" required>
        <span class="input-group-text" style="cursor:pointer" onclick="togglePwd('pwd2','eye2')">
            <i class="bi bi-eye" id="eye2"></i>
        </span>
    </div>
</div>

<div class="d-grid gap-2">
    <button class="btn btn-primary">
        <i class="bi bi-person-check me-1"></i>Create User
    </button>
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>

</form>
</div>
</div>
</div>
</div>

<script>
function togglePwd(inputId, iconId) {
    const el   = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (el.type === 'password') {
        el.type       = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        el.type       = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
@endsection