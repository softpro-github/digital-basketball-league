@extends('layouts.app')
@section('title','Players')
@section('page-title','Players')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">All Players</h5>
    <a href="{{ route('admin.players.create') }}" class="btn btn-warning"><i class="bi bi-person-plus me-1"></i>New Player</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Name</th><th>Team</th><th>Jersey</th><th>Position</th><th>Age</th><th>Height</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($players as $p)
            <tr>
                <td>{{ $players->firstItem() + $loop->index }}</td>
                <td class="fw-semibold">{{ $p->full_name }}</td>
                <td><small>{{ $p->team?->name ?? '<span class="text-muted">—</span>' }}</small></td>
                <td>{{ $p->jersey_number ? '#'.$p->jersey_number : '—' }}</td>
                <td><span class="badge bg-secondary">{{ $p->position ?? '—' }}</span></td>
                <td>{{ $p->age ?? '—' }}</td>
                <td>{{ $p->height ? $p->height.'cm' : '—' }}</td>
                <td>
                    <a href="{{ route('admin.players.show', $p) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.players.edit', $p) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('admin.players.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Delete this player?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No players registered yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $players->links() }}</div>
@endsection
