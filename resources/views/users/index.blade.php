@extends('layouts.app')
@section('title','User Management')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">
        <i class="bi bi-people-fill me-2"></i>User Management
    </h5>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm px-3">
        <i class="bi bi-person-plus me-1"></i>Add User
    </a>
</div>

<div class="card">
    @forelse($users as $user)
    <div class="px-3 py-3 border-bottom">
        <div class="d-flex align-items-center gap-3">

            {{-- Avatar --}}
            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                 style="width:44px;height:44px;background:#1e293b;font-size:.95rem">
                {{ strtoupper(substr($user->name,0,2)) }}
            </div>

            <div class="flex-grow-1">
                <div class="fw-semibold d-flex align-items-center gap-2">
                    {{ $user->name }}
                    @if($user->id === auth()->id())
                    <span class="badge rounded-pill"
                          style="background:#eff6ff;color:#1d4ed8;font-size:.68rem">
                        You
                    </span>
                    @endif
                </div>
                <div class="text-muted small">
                    <i class="bi bi-envelope me-1"></i>{{ $user->email }}
                </div>
                <div class="text-muted" style="font-size:.72rem">
                    <i class="bi bi-clock me-1"></i>
                    Joined {{ $user->created_at->format('d M Y') }}
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-flex gap-1 flex-shrink-0">
                <a href="{{ route('users.edit', $user) }}"
                   class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i>
                </a>
                @if($user->id !== auth()->id())
                <form method="POST" action="{{ route('users.destroy', $user) }}"
                      onsubmit="return confirm('Delete {{ $user->name }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                @endif
            </div>

        </div>
    </div>
    @empty
    <div class="text-center text-muted py-5">
        <i class="bi bi-people fs-2 d-block mb-2 opacity-25"></i>
        No users yet
    </div>
    @endforelse
</div>

@endsection