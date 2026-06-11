@extends('layouts.app')
@section('title','Matches')
@section('page-title','Matches')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">All Fixtures</h5>
    <a href="{{ route('admin.matches.create') }}" class="btn btn-warning"><i class="bi bi-plus-lg me-1"></i>Schedule Match</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>Date</th><th>Home Team</th><th>Score</th><th>Away Team</th><th>League</th><th>Venue</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($matches as $m)
            <tr>
                <td class="small">{{ $m->match_date->format('d M Y') }}<br><span class="text-muted">{{ $m->match_date->format('H:i') }}</span></td>
                <td class="fw-semibold">{{ $m->homeTeam->name }}</td>
                <td class="text-center fw-bold fs-5">
                    @if($m->result)
                        <span class="{{ $m->result->home_total > $m->result->away_total ? 'text-success' : '' }}">{{ $m->result->home_total }}</span>
                        <span class="text-muted mx-1">–</span>
                        <span class="{{ $m->result->away_total > $m->result->home_total ? 'text-success' : '' }}">{{ $m->result->away_total }}</span>
                    @else
                        <span class="text-muted small">vs</span>
                    @endif
                </td>
                <td class="fw-semibold">{{ $m->awayTeam->name }}</td>
                <td class="small">{{ $m->league->name }}</td>
                <td class="small text-muted">{{ $m->venue ?? '—' }}</td>
                <td>
                    <span class="badge bg-{{ $m->status === 'completed' ? 'success' : ($m->status === 'scheduled' ? 'primary' : ($m->status === 'postponed' ? 'warning text-dark' : 'secondary')) }}">
                        {{ ucfirst($m->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.matches.show', $m) }}" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                    @if($m->status === 'scheduled')
                    <a href="{{ route('admin.matches.result', $m) }}" class="btn btn-sm btn-outline-warning" title="Record Result"><i class="bi bi-clipboard-check"></i></a>
                    @endif
                    <a href="{{ route('admin.matches.edit', $m) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form method="POST" action="{{ route('admin.matches.destroy', $m) }}" class="d-inline" onsubmit="return confirm('Delete this match?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">No matches scheduled yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $matches->links() }}</div>
@endsection
