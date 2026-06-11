@extends('layouts.app')
@section('title','Leagues')
@section('page-title','Leagues')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">All Leagues</h5>
    <a href="{{ route('admin.leagues.create') }}" class="btn btn-warning">
        <i class="bi bi-plus-lg me-1"></i>New League
    </a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr>
                <th>#</th><th>Name</th><th>Season</th><th>Status</th><th>Teams</th><th>Dates</th><th>Actions</th>
            </tr></thead>
            <tbody>
            @forelse($leagues as $l)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-semibold">{{ $l->name }}</td>
                <td>{{ $l->season }}</td>
                <td>
                    <span class="badge bg-{{ $l->status === 'active' ? 'success' : ($l->status === 'upcoming' ? 'warning text-dark' : 'secondary') }}">
                        {{ ucfirst($l->status) }}
                    </span>
                </td>
                <td>{{ $l->teams_count }}</td>
                <td class="small text-muted">
                    {{ $l->start_date?->format('d M Y') ?? '—' }} → {{ $l->end_date?->format('d M Y') ?? '—' }}
                </td>
                <td>
                    <a href="{{ route('admin.leagues.show', $l) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.leagues.edit', $l) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('admin.leagues.destroy', $l) }}" class="d-inline"
                          onsubmit="return confirm('Delete this league?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No leagues found. Create one to get started.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $leagues->links() }}</div>
@endsection
