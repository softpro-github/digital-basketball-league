@extends('layouts.app')
@section('title',$team->name)
@section('page-title','Team Roster')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">{{ $team->name }}</h5>
        <small class="text-muted">{{ $team->league->name }} &bull; Home Court: {{ $team->home_court ?? 'N/A' }}</small>
    </div>
    <a href="{{ route('coach.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

<div class="card p-4 mb-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-people-fill me-2 text-warning"></i>Player Roster ({{ $team->players->count() }})</h6>
    @if($team->players->isEmpty())
        <p class="text-muted">No players in this team yet.</p>
    @else
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead><tr><th>#</th><th>Jersey</th><th>Name</th><th>Position</th><th>Age</th><th>Height</th><th>Weight</th><th>Avg PTS</th></tr></thead>
            <tbody>
            @foreach($team->players as $p)
            @php $avg = $p->averageStats() @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><span class="badge bg-dark">#{{ $p->jersey_number ?? '—' }}</span></td>
                <td class="fw-semibold">{{ $p->full_name }}</td>
                <td><span class="badge bg-secondary">{{ $p->position ?? '—' }}</span></td>
                <td>{{ $p->age ?? '—' }}</td>
                <td>{{ $p->height ? $p->height.'cm' : '—' }}</td>
                <td>{{ $p->weight ? $p->weight.'kg' : '—' }}</td>
                <td class="fw-bold text-warning">{{ $avg['points'] }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<div class="card p-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-calendar3 me-2 text-primary"></i>Team Fixtures</h6>
    @if($matches->isEmpty())
        <p class="text-muted">No fixtures scheduled.</p>
    @else
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead><tr><th>Date</th><th>Home</th><th>Score</th><th>Away</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($matches as $m)
            <tr>
                <td class="small">{{ $m->match_date->format('d M Y') }}</td>
                <td class="{{ $m->home_team_id === $team->id ? 'fw-bold' : '' }}">{{ $m->homeTeam->name }}</td>
                <td class="text-center fw-bold">
                    @if($m->result)
                        {{ $m->result->home_total }} – {{ $m->result->away_total }}
                    @else
                        <span class="text-muted">vs</span>
                    @endif
                </td>
                <td class="{{ $m->away_team_id === $team->id ? 'fw-bold' : '' }}">{{ $m->awayTeam->name }}</td>
                <td><span class="badge bg-{{ $m->status === 'completed' ? 'success' : 'primary' }}">{{ ucfirst($m->status) }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
