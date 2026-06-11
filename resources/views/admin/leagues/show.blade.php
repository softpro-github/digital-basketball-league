@extends('layouts.app')
@section('title',$league->name)
@section('page-title','League Details')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="fw-bold mb-0">{{ $league->name }}</h5>
        <small class="text-muted">{{ $league->season }} &bull; <span class="badge bg-{{ $league->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($league->status) }}</span></small>
    </div>
    <a href="{{ route('admin.leagues.edit', $league) }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-pencil me-1"></i>Edit
    </a>
</div>

{{-- Standings Table --}}
<div class="card mb-4 p-3">
    <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-line me-2 text-warning"></i>League Standings</h6>
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead><tr>
                <th>#</th><th>Team</th><th>P</th><th>W</th><th>L</th><th>PF</th><th>PA</th><th>DIFF</th><th>WIN%</th>
            </tr></thead>
            <tbody>
            @forelse($standings as $i => $row)
            <tr class="{{ $i === 0 ? 'table-warning' : '' }}">
                <td>{{ $i + 1 }}</td>
                <td class="fw-semibold">{{ $row['team']->name }}</td>
                <td>{{ $row['played'] }}</td>
                <td class="text-success fw-bold">{{ $row['won'] }}</td>
                <td class="text-danger">{{ $row['lost'] }}</td>
                <td>{{ $row['points_for'] }}</td>
                <td>{{ $row['points_against'] }}</td>
                <td class="{{ $row['diff'] >= 0 ? 'text-success' : 'text-danger' }}">{{ $row['diff'] > 0 ? '+' : '' }}{{ $row['diff'] }}</td>
                <td>{{ $row['win_pct'] }}%</td>
            </tr>
            @empty
            <tr><td colspan="9" class="text-center text-muted">No matches played yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Fixtures --}}
<div class="card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0"><i class="bi bi-calendar3 me-2 text-primary"></i>Fixtures</h6>
        <a href="{{ route('admin.matches.create') }}" class="btn btn-sm btn-warning">
            <i class="bi bi-plus-lg me-1"></i>Add Match
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead><tr><th>Date</th><th>Home</th><th>Score</th><th>Away</th><th>Venue</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse($matches as $m)
            <tr>
                <td class="small">{{ $m->match_date->format('d M Y') }}</td>
                <td class="fw-semibold">{{ $m->homeTeam->name }}</td>
                <td class="text-center fw-bold">
                    @if($m->result)
                        {{ $m->result->home_total }} – {{ $m->result->away_total }}
                    @else
                        <span class="text-muted">vs</span>
                    @endif
                </td>
                <td class="fw-semibold">{{ $m->awayTeam->name }}</td>
                <td class="small text-muted">{{ $m->venue ?? '—' }}</td>
                <td><span class="badge bg-{{ $m->status === 'completed' ? 'success' : ($m->status === 'scheduled' ? 'primary' : 'secondary') }}">{{ ucfirst($m->status) }}</span></td>
                <td>
                    <a href="{{ route('admin.matches.show', $m) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-3">No fixtures scheduled.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
