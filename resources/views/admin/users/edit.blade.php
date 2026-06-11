@extends('layouts.app')
@section('title','Edit User')
@section('page-title','Edit User')
@section('content')
<div class="card p-4" style="max-width:480px">
    <h5 class="fw-bold mb-4">Edit: {{ $user->name }}</h5>
    @if($errors->any())
        <div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Full Name *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role *</label>
            <select name="role" class="form-select" required>
                @foreach(['admin','coach','player'] as $r)
                <option value="{{ $r }}" {{ old('role', $user->role) === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="form-label">New Password <span class="text-muted small">(leave blank to keep current)</span></label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning fw-bold">Save Changes</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
