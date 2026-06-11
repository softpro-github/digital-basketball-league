@extends('layouts.app')
@section('title','Teams')
@section('page-title','Teams')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">All Teams</h5>
    <a href="{{ route('admin.teams.create') }}" class="btn btn-warning"><i class="bi bi-plus-lg me-1"></i>New Team</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>#</th><th>Team</th><th>League</th><th>Coach</th><th>Players</th><th>Home Court</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($teams as $t)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-semibold">{{ $t->name }}</td>
                <td><small>{{ $t->league->name }}</small></td>
                <td>{{ $t->coach?->name ?? '<span class="text-muted">—</span>' }}</td>
                <td><span class="badge bg-primary">{{ $t->players_count }}</span></td>
                <td class="small text-muted">{{ $t->home_court ?? '—' }}</td>
                <td>
                    <a href="{{ route('admin.teams.show', $t) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.teams.edit', $t) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('admin.teams.destroy', $t) }}" class="d-inline" onsubmit="return confirm('Delete this team?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">No teams yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $teams->links() }}</div>
@endsection
