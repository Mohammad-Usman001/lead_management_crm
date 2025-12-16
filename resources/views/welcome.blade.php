<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Diamond IT Solutions | Lead Management CRM</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #240e58 0%, #700aca 100%);
            min-height: 100vh;
        }
        .hero-card {
            border-radius: 1rem;
        }
        .brand-logo {
            max-height: 60px;
        }
        .feature-icon {
            width: 48px;
            height: 48px;
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg border-0 hero-card w-100" style="max-width: 1100px;">
        <div class="row g-0">

            <!-- Left Section -->
            <div class="col-lg-6 p-5 text-white" style="background: linear-gradient(180deg, #1a4a31, #084298); border-radius: 1rem 0 0 1rem;">
                <div class="mb-4">
                    <!-- Replace logo path -->
                    <img src="{{ asset('assets/images/DIAMOND-IT.png') }}" alt="Diamond IT Solutions" class="brand-logo mb-3">
                    <h1 class="fw-bold">Lead Management CRM</h1>
                    <p class="mt-3 opacity-75">
                        A powerful and secure CRM by <strong>Diamond IT Solutions</strong> to manage leads, track sales, and grow your business efficiently.
                    </p>
                </div>

                <ul class="list-unstyled mt-4">
                    <li class="mb-3 d-flex align-items-start">
                        <div class="me-3">✔</div>
                        <span>Centralized lead tracking and management</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <div class="me-3">✔</div>
                        <span>Sales pipeline and follow-up automation</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <div class="me-3">✔</div>
                        <span>Secure access with role-based permissions</span>
                    </li>
                </ul>
            </div>

            <!-- Right Section -->
            <div class="col-lg-6 p-5 bg-white rounded-end">
                <div class="text-end mb-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>

                <h3 class="fw-semibold mb-3">Welcome to Your CRM</h3>
                <p class="text-muted mb-4">
                    Designed for modern teams, our CRM helps you convert leads into customers with clarity and control.
                </p>

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <div class="border rounded p-3 h-100">
                            <h6 class="fw-semibold">Lead Tracking</h6>
                            <p class="text-muted small mb-0">Monitor every lead from first contact to conversion.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="border rounded p-3 h-100">
                            <h6 class="fw-semibold">Sales Insights</h6>
                            <p class="text-muted small mb-0">Analyze performance and optimize your sales strategy.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="border rounded p-3 h-100">
                            <h6 class="fw-semibold">Team Collaboration</h6>
                            <p class="text-muted small mb-0">Work together seamlessly with shared pipelines.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="border rounded p-3 h-100">
                            <h6 class="fw-semibold">Secure & Reliable</h6>
                            <p class="text-muted small mb-0">Built on Laravel with enterprise-grade security.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-center text-muted small">
                    © {{ date('Y') }} Diamond IT Solutions. All rights reserved.<br>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
