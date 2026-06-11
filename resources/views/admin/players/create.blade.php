@extends('layouts.app')
@section('title','Register Player')
@section('page-title','Register Player')
@section('content')
<div class="card p-4" style="max-width:620px">
    <h5 class="fw-bold mb-4">New Player Registration</h5>
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form method="POST" action="{{ route('admin.players.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-6">
                <label class="form-label">First Name *</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
            </div>
            <div class="col-6">
                <label class="form-label">Last Name *</label>
                <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
            </div>
            <div class="col-6">
                <label class="form-label">Team</label>
                <select name="team_id" class="form-select">
                    <option value="">— No team —</option>
                    @foreach($teams as $t)
                    <option value="{{ $t->id }}" {{ old('team_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <label class="form-label">Jersey #</label>
                <input type="number" name="jersey_number" class="form-control" value="{{ old('jersey_number') }}" min="0" max="99">
            </div>
            <div class="col-3">
                <label class="form-label">Position</label>
                <select name="position" class="form-select">
                    <option value="">—</option>
                    @foreach(['PG','SG','SF','PF','C'] as $pos)
                    <option value="{{ $pos }}" {{ old('position') === $pos ? 'selected' : '' }}>{{ $pos }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control" value="{{ old('age') }}" min="14" max="50">
            </div>
            <div class="col-4">
                <label class="form-label">Height (cm)</label>
                <input type="number" name="height" class="form-control" value="{{ old('height') }}" min="140" max="250">
            </div>
            <div class="col-4">
                <label class="form-label">Weight (kg)</label>
                <input type="number" name="weight" class="form-control" value="{{ old('weight') }}" min="40" max="200">
            </div>
        </div>

        <hr class="my-4">
        <h6 class="fw-bold mb-3">Create Login Account (optional)</h6>
        <div class="row g-3">
            <div class="col-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="player@example.com">
            </div>
            <div class="col-6">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min 8 characters">
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-warning fw-bold">Register Player</button>
            <a href="{{ route('admin.players.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
