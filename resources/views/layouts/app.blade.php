<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Basketball League') — DBLMS</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root { --bs-primary: #e85d04; }
body { background: #f5f6fa; }
.sidebar { width: 240px; min-height: 100vh; background: #1a1a2e; position: fixed; top: 0; left: 0; z-index: 100; }
.sidebar-brand { padding: 1.2rem 1rem; background: #e85d04; color: #fff; font-weight: 700; font-size: 1rem; letter-spacing: .5px; }
.sidebar-brand i { font-size: 1.4rem; }
.sidebar .nav-link { color: #adb5bd; padding: .55rem 1.2rem; font-size: .88rem; border-radius: 6px; margin: 1px 8px; }
.sidebar .nav-link:hover, .sidebar .nav-link.active { background: #e85d04; color: #fff; }
.sidebar .nav-section { color: #6c757d; font-size: .7rem; text-transform: uppercase; letter-spacing: 1px; padding: .8rem 1.2rem .2rem; }
.main-content { margin-left: 240px; min-height: 100vh; }
.topbar { background: #fff; border-bottom: 1px solid #dee2e6; padding: .7rem 1.5rem; }
.page-content { padding: 1.5rem; }
.card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.08); border-radius: 10px; }
.stat-card { border-left: 4px solid #e85d04; }
.table thead th { background: #f8f9fa; font-size: .8rem; text-transform: uppercase; letter-spacing: .5px; }
.badge-admin   { background: #dc3545; }
.badge-coach   { background: #0d6efd; }
.badge-player  { background: #198754; }
</style>
@stack('styles')
</head>
<body>

@auth
<div class="sidebar d-flex flex-column">
    <div class="sidebar-brand d-flex align-items-center gap-2">
        <i class="bi bi-trophy-fill"></i>
        <span>Basketball League</span>
    </div>
    <nav class="nav flex-column mt-2 flex-grow-1">

        @if(auth()->user()->isAdmin())
        <span class="nav-section">Administration</span>
        <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>
        <a class="nav-link {{ request()->is('admin/leagues*') ? 'active' : '' }}" href="{{ route('admin.leagues.index') }}">
            <i class="bi bi-trophy me-2"></i>Leagues
        </a>
        <a class="nav-link {{ request()->is('admin/teams*') ? 'active' : '' }}" href="{{ route('admin.teams.index') }}">
            <i class="bi bi-people-fill me-2"></i>Teams
        </a>
        <a class="nav-link {{ request()->is('admin/players*') ? 'active' : '' }}" href="{{ route('admin.players.index') }}">
            <i class="bi bi-person-badge me-2"></i>Players
        </a>
        <a class="nav-link {{ request()->is('admin/matches*') ? 'active' : '' }}" href="{{ route('admin.matches.index') }}">
            <i class="bi bi-calendar3 me-2"></i>Fixtures
        </a>
        @php $pendingCount = \App\Models\LeagueMatch::where('status','scheduled')->where('match_date','<',now())->whereDoesntHave('result')->count(); @endphp
        @if($pendingCount)
        <a class="nav-link d-flex justify-content-between align-items-center" href="{{ route('admin.dashboard') }}#pending">
            <span><i class="bi bi-clipboard-check me-2"></i>Record Results</span>
            <span class="badge bg-warning text-dark">{{ $pendingCount }}</span>
        </a>
        @endif
        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="bi bi-person-gear me-2"></i>Users
        </a>

        @elseif(auth()->user()->isCoach())
        <span class="nav-section">Coach Panel</span>
        <a class="nav-link {{ request()->is('coach') ? 'active' : '' }}" href="{{ route('coach.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>

        @else
        <span class="nav-section">Player Panel</span>
        <a class="nav-link {{ request()->is('player') ? 'active' : '' }}" href="{{ route('player.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </a>
        <a class="nav-link {{ request()->is('player/fixtures') ? 'active' : '' }}" href="{{ route('player.fixtures') }}">
            <i class="bi bi-calendar3 me-2"></i>Fixtures
        </a>
        <a class="nav-link {{ request()->is('player/standings') ? 'active' : '' }}" href="{{ route('player.standings') }}">
            <i class="bi bi-bar-chart-line me-2"></i>Standings
        </a>
        @endif

    </nav>
    <div class="p-3 border-top border-secondary">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold text-secondary">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-2">
            <span class="badge text-bg-{{ auth()->user()->role === 'admin' ? 'danger' : (auth()->user()->role === 'coach' ? 'primary' : 'success') }}">
                {{ ucfirst(auth()->user()->role) }}
            </span>
            <small class="text-muted">{{ auth()->user()->name }}</small>
        </div>
    </div>
    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

@else
    @yield('content')
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
