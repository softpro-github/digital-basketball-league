@extends('layouts.app')
@section('title','Player Dashboard')
@section('page-title','Player Dashboard')
@section('content')
<h5 class="fw-bold mb-1">Welcome, {{ auth()->user()->name }}</h5>
<p class="text-muted mb-4">Your basketball stats and team information.</p>

@if(!$player)
<div class="alert alert-info">Your player profile has not been set up yet. Please contact the administrator.</div>
@else

{{-- Profile + Stats --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width:70px;height:70px">
                <i class="bi bi-person-fill text-white" style="font-size:2rem"></i>
            </div>
            <h6 class="fw-bold mb-1">{{ $player->full_name }}</h6>
            <p class="text-muted small mb-2">{{ $player->team?->name ?? 'No team' }}</p>
            @if($player->jersey_number)
            <span class="badge bg-warning text-dark fs-6 mb-2">#{{ $player->jersey_number }}</span>
            @endif
            <hr>
            <dl class="row text-start small mb-0">
                <dt class="col-5">Position</dt><dd class="col-7">{{ $player->position ?? '—' }}</dd>
                <dt class="col-5">Age</dt><dd class="col-7">{{ $player->age ?? '—' }}</dd>
                <dt class="col-5">Height</dt><dd class="col-7">{{ $player->height ? $player->height.'cm' : '—' }}</dd>
                <dt class="col-5">Weight</dt><dd class="col-7">{{ $player->weight ? $player->weight.'kg' : '—' }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-4 mb-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-graph-up me-2 text-warning"></i>Season Averages</h6>
            @php $avg = $player->averageStats() @endphp
            <div class="row text-center g-3">
                <div class="col"><div class="fw-bold fs-3 text-warning">{{ $avg['points'] }}</div><small class="text-muted">Points</small></div>
                <div class="col"><div class="fw-bold fs-3">{{ $avg['assists'] }}</div><small class="text-muted">Assists</small></div>
                <div class="col"><div class="fw-bold fs-3">{{ $avg['rebounds'] }}</div><small class="text-muted">Rebounds</small></div>
                <div class="col"><div class="fw-bold fs-3">{{ $avg['steals'] }}</div><small class="text-muted">Steals</small></div>
                <div class="col"><div class="fw-bold fs-3">{{ $avg['blocks'] }}</div><small class="text-muted">Blocks</small></div>
            </div>
        </div>
        <div class="card p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-list-ol me-2"></i>Recent Results</h6>
            @forelse($recentResults as $m)
            <div class="d-flex justify-content-between border-bottom pb-2 mb-2 small">
                <span>{{ $m->homeTeam->name }} vs {{ $m->awayTeam->name }}</span>
                <span class="fw-bold text-warning">
                    {{ $m->result?->home_total ?? '?' }} – {{ $m->result?->away_total ?? '?' }}
                </span>
            </div>
            @empty
            <p class="text-muted mb-0">No recent results.</p>
            @endforelse
        </div>
    </div>
</div>
@endif
@endsection
