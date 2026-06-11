@extends('layouts.app')
@section('title','Fixtures')
@section('page-title','Fixtures & Results')
@section('content')
<h5 class="fw-bold mb-4">League Fixtures</h5>

@forelse($leagues as $league)
<div class="card p-4 mb-4">
    <h6 class="fw-bold mb-3">{{ $league->name }} <small class="text-muted fw-normal">{{ $league->season }}</small></h6>
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0">
            <thead><tr><th>Date</th><th>Home</th><th>Score</th><th>Away</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($league->matches as $m)
            <tr>
                <td class="small">{{ $m->match_date->format('d M Y') }}</td>
                <td class="fw-semibold">{{ $m->homeTeam->name }}</td>
                <td class="text-center fw-bold">
                    @if($m->result ?? false)
                        {{ $m->result->home_total }} – {{ $m->result->away_total }}
                    @else
                        <span class="text-muted small">vs</span>
                    @endif
                </td>
                <td class="fw-semibold">{{ $m->awayTeam->name }}</td>
                <td><span class="badge bg-{{ $m->status === 'completed' ? 'success' : ($m->status === 'scheduled' ? 'primary' : 'secondary') }}">{{ ucfirst($m->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted">No fixtures yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="alert alert-info">No active leagues at this time.</div>
@endforelse
@endsection
