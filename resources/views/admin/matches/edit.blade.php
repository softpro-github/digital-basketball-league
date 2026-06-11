@extends('layouts.app')
@section('title','Edit Match')
@section('page-title','Edit Match')
@section('content')
<div class="card p-4" style="max-width:600px">
    <h5 class="fw-bold mb-4">Edit Fixture</h5>
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form method="POST" action="{{ route('admin.matches.update', $match) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">League *</label>
            <select name="league_id" class="form-select" required>
                @foreach($leagues as $l)
                <option value="{{ $l->id }}" {{ old('league_id', $match->league_id) == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-6">
                <label class="form-label">Home Team *</label>
                <select name="home_team_id" class="form-select" required>
                    @foreach($teams as $t)
                    <option value="{{ $t->id }}" {{ old('home_team_id', $match->home_team_id) == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <label class="form-label">Away Team *</label>
                <select name="away_team_id" class="form-select" required>
                    @foreach($teams as $t)
                    <option value="{{ $t->id }}" {{ old('away_team_id', $match->away_team_id) == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-7">
                <label class="form-label">Match Date & Time *</label>
                <input type="datetime-local" name="match_date" class="form-control"
                    value="{{ old('match_date', $match->match_date->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="col-5">
                <label class="form-label">Week</label>
                <input type="number" name="week" class="form-control" value="{{ old('week', $match->week) }}" min="1">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Venue</label>
            <input type="text" name="venue" class="form-control" value="{{ old('venue', $match->venue) }}">
        </div>
        <div class="mb-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach(['scheduled','completed','postponed','cancelled'] as $s)
                <option value="{{ $s }}" {{ old('status', $match->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning fw-bold">Save Changes</button>
            <a href="{{ route('admin.matches.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
