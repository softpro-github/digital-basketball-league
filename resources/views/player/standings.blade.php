@extends('layouts.app')
@section('title','Standings')
@section('page-title','League Standings')
@section('content')
<h5 class="fw-bold mb-4">League Standings</h5>

@forelse($leagues as $league)
<div class="card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="fw-bold mb-0">{{ $league->name }}</h6>
            <small class="text-muted">{{ $league->season }}</small>
        </div>
        <span class="badge bg-{{ $league->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($league->status) }}</span>
    </div>
    @php $standings = $league->standings() @endphp
    @if(empty($standings))
    <p class="text-muted mb-0">No matches played yet.</p>
    @else
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead><tr>
                <th>#</th><th>Team</th><th>P</th><th>W</th><th>L</th><th>PF</th><th>PA</th><th>DIFF</th><th>WIN%</th>
            </tr></thead>
            <tbody>
            @foreach($standings as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row['team']->name }}</td>
                <td>{{ $row['played'] }}</td>
                <td class="text-success">{{ $row['won'] }}</td>
                <td class="text-danger">{{ $row['lost'] }}</td>
                <td>{{ $row['points_for'] }}</td>
                <td>{{ $row['points_against'] }}</td>
                <td class="{{ $row['diff'] >= 0 ? 'text-success' : 'text-danger' }}">{{ $row['diff'] > 0 ? '+' : '' }}{{ $row['diff'] }}</td>
                <td>{{ $row['win_pct'] }}%</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@empty
<div class="alert alert-info">No active leagues at this time.</div>
@endforelse
@endsection
