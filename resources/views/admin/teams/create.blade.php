@extends('layouts.app')
@section('title','Create Team')
@section('page-title','Create Team')
@section('content')
<div class="card p-4" style="max-width:560px">
    <h5 class="fw-bold mb-4">New Team</h5>
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form method="POST" action="{{ route('admin.teams.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Team Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">League *</label>
            <select name="league_id" class="form-select" required>
                <option value="">— Select League —</option>
                @foreach($leagues as $l)
                <option value="{{ $l->id }}" {{ old('league_id') == $l->id ? 'selected' : '' }}>{{ $l->name }} ({{ $l->season }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Coach (optional)</label>
            <select name="coach_id" class="form-select">
                <option value="">— No coach assigned —</option>
                @foreach($coaches as $c)
                <option value="{{ $c->id }}" {{ old('coach_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="form-label">Home Court</label>
            <input type="text" name="home_court" class="form-control" value="{{ old('home_court') }}" placeholder="e.g. National Stadium Court A">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning fw-bold">Create Team</button>
            <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
