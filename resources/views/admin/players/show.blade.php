@extends('layouts.app')
@section('title',$player->full_name)
@section('page-title','Player Profile')
@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <div class="mb-3">
                <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px">
                    <i class="bi bi-person-fill text-white" style="font-size:2.5rem"></i>
                </div>
            </div>
            <h5 class="fw-bold mb-1">{{ $player->full_name }}</h5>
            <p class="text-muted mb-2">{{ $player->team?->name ?? 'Free Agent' }}</p>
            @if($player->jersey_number)
            <span class="badge bg-warning text-dark fs-6">#{{ $player->jersey_number }}</span>
            @endif
            <hr>
            <dl class="row text-start small mb-0">
                <dt class="col-5">Position</dt><dd class="col-7">{{ $player->position ?? '—' }}</dd>
                <dt class="col-5">Age</dt><dd class="col-7">{{ $player->age ?? '—' }}</dd>
                <dt class="col-5">Height</dt><dd class="col-7">{{ $player->height ? $player->height.'cm' : '—' }}</dd>
                <dt class="col-5">Weight</dt><dd class="col-7">{{ $player->weight ? $player->weight.'kg' : '—' }}</dd>
            </dl>
            <div class="mt-3 d-flex gap-2 justify-content-center">
                <a href="{{ route('admin.players.edit', $player) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card p-4 mb-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-graph-up me-2 text-warning"></i>Career Averages</h6>
            @php $avg = $player->averageStats() @endphp
            <div class="row text-center g-3">
                <div class="col"><div class="fw-bold fs-4 text-warning">{{ $avg['points'] }}</div><small class="text-muted">PPG</small></div>
                <div class="col"><div class="fw-bold fs-4">{{ $avg['assists'] }}</div><small class="text-muted">APG</small></div>
                <div class="col"><div class="fw-bold fs-4">{{ $avg['rebounds'] }}</div><small class="text-muted">RPG</small></div>
                <div class="col"><div class="fw-bold fs-4">{{ $avg['steals'] }}</div><small class="text-muted">SPG</small></div>
                <div class="col"><div class="fw-bold fs-4">{{ $avg['blocks'] }}</div><small class="text-muted">BPG</small></div>
            </div>
        </div>
        <div class="card p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-list-ol me-2"></i>Recent Game Logs</h6>
            @if($player->stats->isEmpty())
                <p class="text-muted mb-0">No game data recorded.</p>
            @else
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Match</th><th>PTS</th><th>AST</th><th>REB</th><th>STL</th><th>BLK</th><th>MIN</th></tr></thead>
                    <tbody>
                    @foreach($player->stats->take(10) as $s)
                    <tr>
                        <td class="small">{{ $s->match->homeTeam->name }} vs {{ $s->match->awayTeam->name }}</td>
                        <td class="fw-bold text-warning">{{ $s->points }}</td>
                        <td>{{ $s->assists }}</td>
                        <td>{{ $s->rebounds }}</td>
                        <td>{{ $s->steals }}</td>
                        <td>{{ $s->blocks }}</td>
                        <td>{{ $s->minutes_played }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
