@extends('layouts.app')
@section('title',$team->name)
@section('page-title','Team Details')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0">{{ $team->name }}</h5>
        <small class="text-muted">{{ $team->league->name }} &bull; Coach: {{ $team->coach?->name ?? 'Unassigned' }}</small>
    </div>
    <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil me-1"></i>Edit</a>
</div>
<div class="card p-3">
    <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Player Roster ({{ $team->players->count() }})</h6>
    @if($team->players->isEmpty())
        <p class="text-muted">No players assigned to this team.</p>
    @else
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead><tr><th>#</th><th>Name</th><th>Jersey</th><th>Position</th><th>Age</th></tr></thead>
            <tbody>
            @foreach($team->players as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-semibold">{{ $p->full_name }}</td>
                <td>#{{ $p->jersey_number ?? '—' }}</td>
                <td><span class="badge bg-secondary">{{ $p->position ?? '—' }}</span></td>
                <td>{{ $p->age ?? '—' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
    <div class="mt-3">
        <a href="{{ route('admin.players.create') }}" class="btn btn-sm btn-warning">
            <i class="bi bi-person-plus me-1"></i>Add Player
        </a>
    </div>
</div>
@endsection
