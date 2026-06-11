@extends('layouts.app')
@section('title','Edit Team')
@section('page-title','Edit Team')
@section('content')
<div class="card p-4" style="max-width:560px">
    <h5 class="fw-bold mb-4">Edit: {{ $team->name }}</h5>
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form method="POST" action="{{ route('admin.teams.update', $team) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Team Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $team->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">League *</label>
            <select name="league_id" class="form-select" required>
                @foreach($leagues as $l)
                <option value="{{ $l->id }}" {{ old('league_id', $team->league_id) == $l->id ? 'selected' : '' }}>{{ $l->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Coach</label>
            <select name="coach_id" class="form-select">
                <option value="">— None —</option>
                @foreach($coaches as $c)
                <option value="{{ $c->id }}" {{ old('coach_id', $team->coach_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="form-label">Home Court</label>
            <input type="text" name="home_court" class="form-control" value="{{ old('home_court', $team->home_court) }}">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning fw-bold">Save Changes</button>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
