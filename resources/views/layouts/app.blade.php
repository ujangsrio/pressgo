<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Absensi Digital - PressGO')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 untuk notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .viewport {
            width: 100%;
            height: 300px;
            border: 2px solid #dee2e6;
            border-radius: 0.375rem;
            background: #000;
        }
        
        .status-present {
            color: #198754;
            font-weight: bold;
        }
        
        .status-late {
            color: #fd7e14;
            font-weight: bold;
        }
        
        .status-absent {
            color: #dc3545;
            font-weight: bold;
        }
        
        .scan-container {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .navbar-brand {
            font-weight: 600;
        }

        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border-radius: 0.375rem;
            margin: 0 0.125rem;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
        }

        .navbar-nav .nav-link.active {
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ auth()->guard('participant')->check() ? route('participant.dashboard') : url('/') }}">
                <i class="fas fa-qrcode me-2"></i>PressGO
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Navigation links for authenticated participant users -->
                    @if(auth()->guard('participant')->check())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('participant.dashboard') ? 'active' : '' }}" 
                           href="{{ route('participant.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('participant.attendance.scan') ? 'active' : '' }}" 
                           href="{{ route('participant.attendance.scan') }}">
                            <i class="fas fa-qrcode me-1"></i>Scan Absensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('participant.attendance.index') ? 'active' : '' }}" 
                           href="{{ route('participant.attendance.index') }}">
                            <i class="fas fa-history me-1"></i>Riwayat Absensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('participant.settings.*') ? 'active' : '' }}" 
                           href="{{ route('participant.settings.index') }}">
                            <i class="fas fa-cog me-1"></i>Pengaturan
                        </a>
                    </li>
                    @endif
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    <!-- Admin Authentication -->
                    @auth('web')
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-shield me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-1"></i>Logout Admin
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li> --}}
                    
                    <!-- Participant Authentication -->
                    @elseif(auth()->guard('participant')->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="{{ auth()->guard('participant')->user()->gambar_url }}" 
                                 alt="{{ auth()->guard('participant')->user()->name }}" 
                                 class="user-avatar">
                            <span>{{ auth()->guard('participant')->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('participant.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('participant.attendance.scan') }}">
                                    <i class="fas fa-qrcode me-1"></i>Scan Absensi
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('participant.settings.index') }}">
                                    <i class="fas fa-cog me-1"></i>Pengaturan Akun
                                </a>
                            </li>
                            {{-- <li><hr class="dropdown-divider"></li> --}}
                            {{-- <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-id-card me-1"></i>{{ auth()->guard('participant')->user()->nim }}
                                </a>
                            </li> --}}
                            {{-- <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-graduation-cap me-1"></i>{{ auth()->guard('participant')->user()->program_type }}
                                </a>
                            </li> --}}
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('participant.logout') }}" id="participant-logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Guest Users -->
                    @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('participant.login') ? 'active' : '' }}" 
                           href="{{ route('participant.login') }}">
                            <i class="fas fa-user me-1"></i>Login Peserta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.login') ? 'active' : '' }}" 
                           href="{{ route('admin.login') }}">
                            <i class="fas fa-user-shield me-1"></i>Admin Login
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <!-- Success Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Error Messages -->
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Handle participant logout with confirmation
    document.addEventListener('DOMContentLoaded', function() {
        const logoutForm = document.getElementById('participant-logout-form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: 'Apakah Anda yakin ingin logout?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        const button = this.querySelector('button[type="submit"]');
                        const originalText = button.innerHTML;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Logging out...';
                        button.disabled = true;
                        
                        // Submit form after a short delay to show loading state
                        setTimeout(() => {
                            this.submit();
                        }, 500);
                    }
                });
            });
        }

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        });

        // Highlight active nav link
        const currentPath = window.location.pathname;
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });
    </script>
    
    @yield('scripts')
</body>
</html>