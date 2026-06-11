@extends('layouts.app')
@section('title','Record Result')
@section('page-title','Record Match Result')
@section('content')
<h5 class="fw-bold mb-1">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h5>
<p class="text-muted mb-4">{{ $match->league->name }} &bull; {{ $match->match_date->format('D d M Y') }}</p>

@if($errors->any())
    <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
@endif

<form method="POST" action="{{ route('admin.matches.storeResult', $match) }}">
@csrf

{{-- Quarter Scores --}}
<div class="card p-4 mb-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-123 me-2 text-warning"></i>Quarter Scores</h6>
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead class="table-dark">
                <tr><th>Team</th><th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th class="table-secondary">Total</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold align-middle">{{ $match->homeTeam->name }} <span class="badge bg-secondary">HOME</span></td>
                    <td><input type="number" name="home_q1" class="form-control score-input" id="hq1" value="{{ old('home_q1', 0) }}" min="0" required></td>
                    <td><input type="number" name="home_q2" class="form-control score-input" id="hq2" value="{{ old('home_q2', 0) }}" min="0" required></td>
                    <td><input type="number" name="home_q3" class="form-control score-input" id="hq3" value="{{ old('home_q3', 0) }}" min="0" required></td>
                    <td><input type="number" name="home_q4" class="form-control score-input" id="hq4" value="{{ old('home_q4', 0) }}" min="0" required></td>
                    <td class="align-middle fw-bold fs-5 text-warning text-center" id="homeTotal">0</td>
                </tr>
                <tr>
                    <td class="fw-bold align-middle">{{ $match->awayTeam->name }} <span class="badge bg-outline-secondary">AWAY</span></td>
                    <td><input type="number" name="away_q1" class="form-control score-input" id="aq1" value="{{ old('away_q1', 0) }}" min="0" required></td>
                    <td><input type="number" name="away_q2" class="form-control score-input" id="aq2" value="{{ old('away_q2', 0) }}" min="0" required></td>
                    <td><input type="number" name="away_q3" class="form-control score-input" id="aq3" value="{{ old('away_q3', 0) }}" min="0" required></td>
                    <td><input type="number" name="away_q4" class="form-control score-input" id="aq4" value="{{ old('away_q4', 0) }}" min="0" required></td>
                    <td class="align-middle fw-bold fs-5 text-warning text-center" id="awayTotal">0</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <label class="form-label">Match Notes</label>
        <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes about the match...">{{ old('notes') }}</textarea>
    </div>
</div>

{{-- Player Stats --}}
<div class="card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Player Statistics</h6>
        <small class="text-muted">Enter stats for players who participated</small>
    </div>

    @php
        $homePlayers = $match->homeTeam->players;
        $awayPlayers = $match->awayTeam->players;
        $allPlayers = $homePlayers->concat($awayPlayers);
    @endphp

    @if($allPlayers->isEmpty())
        <p class="text-muted">No players assigned to either team yet.</p>
    @else

    {{-- Home Team --}}
    @if($homePlayers->isNotEmpty())
    <h6 class="fw-semibold text-muted mb-2">{{ $match->homeTeam->name }}</h6>
    <div class="table-responsive mb-4">
        <table class="table table-sm table-bordered">
            <thead class="table-light"><tr>
                <th>Player</th><th>#</th><th>PTS</th><th>AST</th><th>REB</th><th>STL</th><th>BLK</th><th>FLS</th><th>MIN</th>
            </tr></thead>
            <tbody>
            @foreach($homePlayers as $i => $p)
            <tr>
                <td class="fw-semibold align-middle">{{ $p->full_name }}</td>
                <td class="text-muted align-middle">{{ $p->jersey_number ?? '—' }}</td>
                @php $pi = 'home_'.$i @endphp
                <input type="hidden" name="stats[{{ $pi }}][player_id]" value="{{ $p->id }}">
                <input type="hidden" name="stats[{{ $pi }}][team_id]" value="{{ $match->home_team_id }}">
                <td><input type="number" name="stats[{{ $pi }}][points]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.points', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][assists]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.assists', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][rebounds]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.rebounds', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][steals]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.steals', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][blocks]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.blocks', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][fouls]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.fouls', 0) }}" min="0" max="6"></td>
                <td><input type="number" name="stats[{{ $pi }}][minutes_played]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.minutes_played', 0) }}" min="0" max="48"></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Away Team --}}
    @if($awayPlayers->isNotEmpty())
    <h6 class="fw-semibold text-muted mb-2">{{ $match->awayTeam->name }}</h6>
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="table-light"><tr>
                <th>Player</th><th>#</th><th>PTS</th><th>AST</th><th>REB</th><th>STL</th><th>BLK</th><th>FLS</th><th>MIN</th>
            </tr></thead>
            <tbody>
            @foreach($awayPlayers as $i => $p)
            <tr>
                <td class="fw-semibold align-middle">{{ $p->full_name }}</td>
                <td class="text-muted align-middle">{{ $p->jersey_number ?? '—' }}</td>
                @php $pi = 'away_'.$i @endphp
                <input type="hidden" name="stats[{{ $pi }}][player_id]" value="{{ $p->id }}">
                <input type="hidden" name="stats[{{ $pi }}][team_id]" value="{{ $match->away_team_id }}">
                <td><input type="number" name="stats[{{ $pi }}][points]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.points', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][assists]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.assists', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][rebounds]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.rebounds', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][steals]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.steals', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][blocks]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.blocks', 0) }}" min="0"></td>
                <td><input type="number" name="stats[{{ $pi }}][fouls]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.fouls', 0) }}" min="0" max="6"></td>
                <td><input type="number" name="stats[{{ $pi }}][minutes_played]" class="form-control form-control-sm" value="{{ old('stats.'.$pi.'.minutes_played', 0) }}" min="0" max="48"></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @endif
</div>

<div class="d-flex gap-2 mb-5">
    <button type="submit" class="btn btn-warning fw-bold px-4">
        <i class="bi bi-check-lg me-1"></i>Save Result & Stats
    </button>
    <a href="{{ route('admin.matches.show', $match) }}" class="btn btn-outline-secondary">Cancel</a>
</div>
</form>

<script>
function updateTotals() {
    const get = id => parseInt(document.getElementById(id)?.value) || 0;
    document.getElementById('homeTotal').textContent = get('hq1') + get('hq2') + get('hq3') + get('hq4');
    document.getElementById('awayTotal').textContent = get('aq1') + get('aq2') + get('aq3') + get('aq4');
}
document.querySelectorAll('.score-input').forEach(el => el.addEventListener('input', updateTotals));
updateTotals();
</script>
@endsection
