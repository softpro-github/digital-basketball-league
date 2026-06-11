@extends('layouts.app')
@section('title','Admin Dashboard')
@section('page-title','Dashboard')
@section('content')

<div class="row g-4 mb-4">
    @foreach([
        ['bi-trophy','text-warning','bg-warning bg-opacity-10',$totalLeagues,'Leagues'],
        ['bi-people-fill','text-primary','bg-primary bg-opacity-10',$totalTeams,'Teams'],
        ['bi-person-badge','text-success','bg-success bg-opacity-10',$totalPlayers,'Players'],
        ['bi-person-gear','text-danger','bg-danger bg-opacity-10',$totalUsers,'System Users'],
    ] as [$icon,$color,$bg,$val,$label])
    <div class="col-6 col-md-3">
        <div class="card stat-card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">{{ $label }}</div>
                    <div class="fw-bold fs-3">{{ $val }}</div>
                </div>
                <div class="rounded-3 p-2 {{ $bg }}">
                    <i class="bi {{ $icon }} {{ $color }} fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Pending Results Alert --}}
@if($pendingResults->count())
<div class="card p-3 mb-4 border-start border-4 border-warning">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0 text-warning"><i class="bi bi-clipboard-check me-2"></i>Pending Results ({{ $pendingResults->count() }} match{{ $pendingResults->count() > 1 ? 'es' : '' }} need results)</h6>
        <a href="{{ route('admin.matches.index') }}" class="btn btn-sm btn-outline-warning">View All Fixtures</a>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead><tr><th>Date</th><th>Home</th><th>Away</th><th>League</th><th>Action</th></tr></thead>
            <tbody>
            @foreach($pendingResults as $m)
            <tr>
                <td class="small text-danger fw-semibold">{{ $m->match_date->format('d M Y') }}</td>
                <td class="fw-semibold">{{ $m->homeTeam->name }}</td>
                <td class="fw-semibold">{{ $m->awayTeam->name }}</td>
                <td class="small text-muted">{{ $m->league->name }}</td>
                <td>
                    <a href="{{ route('admin.matches.result', $m) }}" class="btn btn-warning btn-sm fw-bold">
                        <i class="bi bi-clipboard-check me-1"></i>Record Result
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="row g-4">
    <div class="col-md-6">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-calendar3 me-2 text-primary"></i>Upcoming Fixtures</h6>
                <a href="{{ route('admin.matches.create') }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-plus-lg me-1"></i>Schedule Match
                </a>
            </div>
            @forelse($upcomingMatches as $m)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                    <div class="fw-semibold small">{{ $m->homeTeam->name }} <span class="text-muted">vs</span> {{ $m->awayTeam->name }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ $m->league->name }} &bull; {{ $m->match_date->format('d M Y, g:ia') }}</div>
                </div>
                <div class="d-flex gap-1 align-items-center">
                    <span class="badge bg-primary">Week {{ $m->week ?? '—' }}</span>
                    <a href="{{ route('admin.matches.show', $m) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                </div>
            </div>
            @empty
            <p class="text-muted small mb-0">No upcoming matches.</p>
            @endforelse
            <div class="mt-2">
                <a href="{{ route('admin.matches.index') }}" class="btn btn-sm btn-outline-primary">View All Fixtures</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-check-circle me-2 text-success"></i>Recent Results</h6>
            @forelse($recentResults as $m)
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div class="fw-semibold small">{{ $m->homeTeam->name }}</div>
                <div class="text-center px-2">
                    <span class="fw-bold fs-6">{{ $m->result?->home_total ?? '?' }}</span>
                    <span class="text-muted mx-1">–</span>
                    <span class="fw-bold fs-6">{{ $m->result?->away_total ?? '?' }}</span>
                </div>
                <div class="fw-semibold small text-end">{{ $m->awayTeam->name }}</div>
            </div>
            @empty
            <p class="text-muted small mb-0">No results recorded yet.</p>
            @endforelse
        </div>
    </div>
</div>

@if($activeLeagues->count())
<div class="card mt-4 p-3">
    <h6 class="fw-bold mb-3"><i class="bi bi-trophy me-2 text-warning"></i>Active Leagues</h6>
    <div class="row g-3">
        @foreach($activeLeagues as $league)
        <div class="col-md-4">
            <div class="border rounded p-3 d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-semibold">{{ $league->name }}</div>
                    <small class="text-muted">{{ $league->season }} &bull; {{ $league->teams->count() }} teams</small>
                </div>
                <a href="{{ route('admin.leagues.show', $league) }}" class="btn btn-sm btn-outline-warning">View</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection
