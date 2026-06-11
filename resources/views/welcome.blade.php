<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Digital Basketball League Management System</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
.hero { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #e85d04 100%); min-height: 100vh; }
.feature-card { border: none; border-radius: 12px; transition: transform .2s; }
.feature-card:hover { transform: translateY(-4px); }
.feature-icon { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
</style>
</head>
<body class="bg-light">

<div class="hero d-flex flex-column justify-content-center align-items-center text-white text-center px-3" style="min-height:65vh">
    <i class="bi bi-trophy-fill text-warning" style="font-size:4rem"></i>
    <h1 class="fw-bold mt-3">Digital Basketball League<br>Management System</h1>
    <p class="text-white-50 mt-2 mb-4" style="max-width:520px">
        A modern platform for managing youth basketball leagues in Nigeria — player registration, team management, fixtures, results and standings all in one place.
    </p>
    <div class="d-flex gap-3 flex-wrap justify-content-center">
        <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4 fw-bold">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </a>
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
            <i class="bi bi-person-plus me-2"></i>Register
        </a>
    </div>
</div>

<div class="container py-5">
    <h2 class="text-center fw-bold mb-5">System Features</h2>
    <div class="row g-4">
        @foreach([
            ['bi-person-badge','#e85d04','Player Registration','Register players with full profiles, positions and team assignments.'],
            ['bi-people-fill','#0d6efd','Team Management','Create and manage teams with coaches and player rosters.'],
            ['bi-calendar3','#198754','Match Scheduling','Schedule fixtures with automatic conflict detection.'],
            ['bi-graph-up','#6f42c1','Performance Tracking','Track points, assists, rebounds, steals and blocks per match.'],
            ['bi-bar-chart-line','#fd7e14','League Standings','Auto-calculated standings table based on match results.'],
            ['bi-person-gear','#20c997','Role-Based Access','Separate dashboards for Admins, Coaches and Players.'],
        ] as [$icon,$color,$title,$desc])
        <div class="col-md-4">
            <div class="card feature-card shadow-sm p-4">
                <div class="feature-icon mb-3" style="background:{{ $color }}22">
                    <i class="bi {{ $icon }}" style="color:{{ $color }}"></i>
                </div>
                <h5 class="fw-bold">{{ $title }}</h5>
                <p class="text-muted mb-0 small">{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<footer class="text-center py-3 text-muted small border-top">
    &copy; {{ date('Y') }} Digital Basketball League Management System &mdash; Edo State University, Iyamho
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
