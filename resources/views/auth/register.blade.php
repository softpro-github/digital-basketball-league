@extends('layouts.app')
@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#1a1a2e,#16213e)">
    <div class="card shadow-lg p-4" style="width:100%;max-width:420px;border-radius:16px">
        <div class="text-center mb-4">
            <i class="bi bi-person-plus-fill text-warning" style="font-size:2.5rem"></i>
            <h4 class="fw-bold mt-2 mb-0">Create Account</h4>
            <small class="text-muted">Register as a player</small>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2">
                @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning w-100 fw-bold">
                <i class="bi bi-person-check me-2"></i>Register
            </button>
        </form>

        <div class="text-center mt-3 small text-muted">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</div>
@endsection
