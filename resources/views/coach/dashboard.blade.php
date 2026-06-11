@extends('layouts.app')
@section('title','Coach Dashboard')
@section('page-title','Coach Dashboard')
@section('content')
<h5 class="fw-bold mb-1">Welcome, {{ auth()->user()->name }}</h5>
<p class="text-muted mb-4">Here's an overview of your teams and upcoming fixtures.</p>

@if($teams->isEmpty())
<div class="alert alert-info">You have not been assigned to any teams yet. Contact the administrator.</div>
@else

{{-- Teams Overview --}}
<div class="row g-3 mb-4">
@foreach($teams as $team)
<div class="col-md-6">
    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="fw-bold mb-0">{{ $team->name }}</h6>
                <small class="text-muted">{{ $team->league->name }}</small>
            </div>
            <a href="{{ route('coach.team', $team->id) }}" class="btn btn-sm btn-outline-warning">View Roster</a>
        </div>
        <hr class="my-2">
        <div class="d-flex gap-4">
            <div>
                <div class="fw-bold text-primary fs-5">{{ $team->players->count() }}</div>
                <small class="text-muted">Players</small>
            </div>
            <div>
                <div class="fw-bold text-success fs-5">
                    {{ $team->homeMatches->where('status','completed')->count() + $team->awayMatches->where('status','completed')->count() }}
                </div>
                <small class="text-muted">Matches Played</small>
            </div>
        </div>
    </div>
</div>
@endforeach
</div>

{{-- Upcoming Fixtures --}}
<div class="row g-4">
<div class="col-md-6">
    <div class="card p-3">
        <h6 class="fw-bold mb-3"><i class="bi bi-calendar-event me-2 text-primary"></i>Upcoming Fixtures</h6>
        @forelse($upcomingMatches as $m)
        <div class="border rounded p-2 mb-2">
            <div class="d-flex justify-content-between small">
                <span class="fw-bold">{{ $m->homeTeam->name }} vs {{ $m->awayTeam->name }}</span>
                <span class="text-muted">{{ $m->match_date->format('d M') }}</span>
            </div>
            <div class="text-muted small">{{ $m->venue ?? 'Venue TBD' }}</div>
        </div>
        @empty
        <p class="text-muted mb-0">No upcoming matches.</p>
        @endforelse
    </div>
</div>

{{-- Recent Results --}}
<div class="col-md-6">
    <div class="card p-3">
        <h6 class="fw-bold mb-3"><i class="bi bi-trophy me-2 text-warning"></i>Recent Results</h6>
        @forelse($recentResults as $m)
        <div class="border rounded p-2 mb-2">
            <div class="d-flex justify-content-between align-items-center">
                <span class="small fw-bold">{{ $m->homeTeam->name }}</span>
                <span class="fw-bold text-warning">
                    {{ $m->result?->home_total ?? '?' }} – {{ $m->result?->away_total ?? '?' }}
                </span>
                <span class="small fw-bold">{{ $m->awayTeam->name }}</span>
            </div>
        </div>
        @empty
        <p class="text-muted mb-0">No results yet.</p>
        @endforelse
    </div>
</div>
</div>
@endif
@endsection
