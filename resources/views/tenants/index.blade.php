@extends('layouts.app')
@section('title', 'Tenants')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-people me-2"></i>Tenants</h4>
    <a href="{{ route('tenants.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Tenant
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Room</th>
                    <th>Phone</th>
                    <th>Move In</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr>
                    <td class="fw-semibold">{{ $tenant->name }}</td>
                    <td>{{ $tenant->room->name }}</td>
                    <td>{{ $tenant->phone ?? '—' }}</td>
                    <td>{{ $tenant->move_in_date->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $tenant->is_active ? 'success' : 'secondary' }}">
                            {{ $tenant->is_active ? 'Active' : 'Moved Out' }}
                        </span>
                    </td>
                    <td>
                        @if($tenant->is_active)
                        <form method="POST" action="{{ route('tenants.destroy', $tenant) }}"
                              onsubmit="return confirm('Check out {{ $tenant->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-box-arrow-right me-1"></i>Check Out
                            </button>
                        </form>
                        @else
                            <span class="text-muted small">Moved out {{ $tenant->move_out_date?->format('d M Y') }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-people fs-3 d-block mb-2"></i>No tenants yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection