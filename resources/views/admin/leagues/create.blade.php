@extends('layouts.app')
@section('title','Create League')
@section('page-title','Create League')
@section('content')
<div class="card p-4" style="max-width:600px">
    <h5 class="fw-bold mb-4">New League</h5>
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form method="POST" action="{{ route('admin.leagues.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">League Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Season *</label>
            <input type="text" name="season" class="form-control" value="{{ old('season','2025/2026') }}" required placeholder="e.g. 2025/2026">
        </div>
        <div class="mb-3">
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                @foreach(['upcoming','active','completed'] as $s)
                <option value="{{ $s }}" {{ old('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning fw-bold">Create League</button>
            <a href="{{ route('admin.leagues.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
