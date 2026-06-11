@extends('layouts.app')
@section('title','Match Details')
@section('page-title','Match Details')
@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        <h5 class="fw-bold mb-0">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h5>
        <small class="text-muted">{{ $match->league->name }} &bull; {{ $match->match_date->format('D d M Y, H:i') }}</small>
    </div>
    <div class="d-flex gap-2">
        @if($match->status === 'scheduled')
        <a href="{{ route('admin.matches.result', $match) }}" class="btn btn-warning btn-sm fw-bold">
            <i class="bi bi-clipboard-check me-1"></i>Record Result
        </a>
        @endif
        <a href="{{ route('admin.matches.edit', $match) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
    </div>
</div>

{{-- Scoreboard --}}
<div class="card p-4 mb-4">
    @if($match->result)
    <div class="row text-center align-items-center">
        <div class="col-4">
            <div class="fw-bold fs-5">{{ $match->homeTeam->name }}</div>
            <div class="display-4 fw-bold text-warning">{{ $match->result->home_total }}</div>
            <small class="text-muted">HOME</small>
        </div>
        <div class="col-4">
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-dark"><tr><th></th><th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th>T</th></tr></thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">Home</td>
                            <td>{{ $match->result->home_q1 }}</td>
                            <td>{{ $match->result->home_q2 }}</td>
                            <td>{{ $match->result->home_q3 }}</td>
                            <td>{{ $match->result->home_q4 }}</td>
                            <td class="fw-bold">{{ $match->result->home_total }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Away</td>
                            <td>{{ $match->result->away_q1 }}</td>
                            <td>{{ $match->result->away_q2 }}</td>
                            <td>{{ $match->result->away_q3 }}</td>
                            <td>{{ $match->result->away_q4 }}</td>
                            <td class="fw-bold">{{ $match->result->away_total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-2 fw-bold text-success">
                Winner: {{ $match->result->winner()?->name ?? 'Draw' }}
            </div>
        </div>
        <div class="col-4">
            <div class="fw-bold fs-5">{{ $match->awayTeam->name }}</div>
            <div class="display-4 fw-bold text-warning">{{ $match->result->away_total }}</div>
            <small class="text-muted">AWAY</small>
        </div>
    </div>
    @else
    <div class="text-center py-4">
        <i class="bi bi-hourglass-split text-muted" style="font-size:3rem"></i>
        <p class="text-muted mt-2">Result not yet recorded.</p>
        <a href="{{ route('admin.matches.result', $match) }}" class="btn btn-warning fw-bold">
            <i class="bi bi-clipboard-check me-1"></i>Record Result Now
        </a>
    </div>
    @endif
</div>

{{-- Player Stats --}}
@if($match->playerStats->isNotEmpty())
<div class="card p-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Player Statistics</h6>
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead><tr><th>Player</th><th>Team</th><th>PTS</th><th>AST</th><th>REB</th><th>STL</th><th>BLK</th><th>FLS</th><th>MIN</th></tr></thead>
            <tbody>
            @foreach($match->playerStats as $s)
            <tr>
                <td class="fw-semibold">{{ $s->player->full_name }}</td>
                <td class="small text-muted">{{ $s->team->name }}</td>
                <td class="fw-bold text-warning">{{ $s->points }}</td>
                <td>{{ $s->assists }}</td>
                <td>{{ $s->rebounds }}</td>
                <td>{{ $s->steals }}</td>
                <td>{{ $s->blocks }}</td>
                <td class="{{ $s->fouls >= 5 ? 'text-danger fw-bold' : '' }}">{{ $s->fouls }}</td>
                <td>{{ $s->minutes_played }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
