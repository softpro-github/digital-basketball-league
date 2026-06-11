@extends('layouts.app')
@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#1a1a2e,#16213e)">
    <div class="card shadow-lg p-4" style="width:100%;max-width:400px;border-radius:16px">
        <div class="text-center mb-4">
            <i class="bi bi-trophy-fill text-warning" style="font-size:2.5rem"></i>
            <h4 class="fw-bold mt-2 mb-0">Basketball League</h4>
            <small class="text-muted">Sign in to your account</small>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus placeholder="admin@basketball.com">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-warning w-100 fw-bold">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login
            </button>
        </form>

        <div class="text-center mt-3 small text-muted">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
        </div>

        <hr class="my-3">
        <div class="small text-muted">
            <strong>Demo accounts:</strong><br>
            Admin: admin@basketball.com / admin123<br>
            Coach: coach@basketball.com / coach123<br>
            Player: player@basketball.com / player123
        </div>
    </div>
</div>
@endsection
