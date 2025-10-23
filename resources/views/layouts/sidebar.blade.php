<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PressGO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    {{-- <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* ===== SIDEBAR ===== */
        #sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            transition: margin-left 0.3s ease;
            width: 280px;
            position: fixed;
            z-index: 1000;
        }

        /* posisi sidebar tertutup */
        #sidebar.closed {
            margin-left: -280px;
        }

        #sidebar .sidebar-header {
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sidebar .sidebar-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.3rem;
        }

        #sidebar ul.components {
            padding: 1rem 0;
        }

        #sidebar ul li {
            margin: 0.5rem 1rem;
        }

        #sidebar ul li a {
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }

        #sidebar ul li a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        #sidebar ul li a.active {
            background: rgba(52, 152, 219, 0.3);
            color: white;
            border-left: 4px solid #3498db;
        }

        #sidebar ul li a i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        #sidebar .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* ===== CONTENT ===== */
        #content {
            margin-left: 280px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        /* ketika sidebar ditutup */
        #content.expanded {
            margin-left: 0;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #dee2e6;
        }

        .main-content {
            padding: 2rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -280px;
            }

            #sidebar.closed {
                margin-left: -280px;
            }

            #sidebar.open {
                margin-left: 0;
            }

            #content {
                margin-left: 0;
            }

            #content.expanded {
                margin-left: 0;
            }

            #sidebarCollapse span {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- ===== SIDEBAR ===== -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><i class="bi bi-person-badge"></i>PressGO</h3>
            <small class="text-muted">Admin Panel</small>
        </div>

        <ul class="list-unstyled components">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" 
                href="{{ route('dashboard.index') }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.index') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Data Absensi
                </a>
            </li>
            <li>
                <a href="{{ route('attendance.scan') }}" class="{{ request()->routeIs('attendance.scan') ? 'active' : '' }}">
                    <i class="bi bi-upc-scan"></i> Scan Barcode
                </a>
            </li>
            <li>
                <a href="{{ route('participants.index') }}" class="{{ request()->routeIs('participants.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Manajemen Peserta
                </a>
            </li>
            <li>
                <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> Pengaturan
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center">
                <div class="user-avatar me-3">{{ substr(session('admin_name'), 0, 1) }}</div>
                <div class="user-info">
                    <small class="d-block text-white">{{ session('admin_name') }}</small>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== CONTENT ===== -->
    <div id="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-outline-primary">
                    <i class="bi bi-list"></i> <span>Menu</span>
                </button>

                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="user-avatar me-2">{{ substr(session('admin_name'), 0, 1) }}</div>
                            <span>{{ session('admin_name') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('settings.index') }}">
                                    <i class="bi bi-gear"></i> Pengaturan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- ===== SCRIPT ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("content");
            const toggleButton = document.getElementById("sidebarCollapse");

            // Klik tombol Menu untuk buka/tutup sidebar
            toggleButton.addEventListener("click", function () {
                sidebar.classList.toggle("closed");
                content.classList.toggle("expanded");
            });

            // Jika di mobile, tutup sidebar saat klik di luar
            document.addEventListener("click", function (e) {
                if (window.innerWidth <= 768) {
                    const isClickInsideSidebar = sidebar.contains(e.target);
                    const isClickInsideToggle = toggleButton.contains(e.target);

                    if (!isClickInsideSidebar && !isClickInsideToggle) {
                        sidebar.classList.add("closed");
                        content.classList.add("expanded");
                    }
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
