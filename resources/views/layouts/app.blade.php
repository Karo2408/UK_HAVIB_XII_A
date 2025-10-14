<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/PPS.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />

    <style>
        .logo-small {
            width: 80px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .brand-logo {
            justify-content: center !important;
            padding: 15px 0;
        }

        .logo-navbar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
        data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar -->
<aside class="left-sidebar">
    <div>
        <!-- Logo -->
        <div class="brand-logo d-flex align-items-center">
            <a href="{{ url('/') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/PPS.PNG') }}" alt="Logo" class="logo-small" />
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                {{-- ADMIN MENU --}}
                @if(Auth::user()->Role == 'admin')

                <!-- Home Section -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">Home</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <div class="nav-link disabled">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Diskon saat ini: {{ \App\Setting::getValue('diskon_global') }}%</span>
                    </div>
                </li>

                <!-- Menu Section -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">Menu</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('kategori.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:layers-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('produk.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:box-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Produk</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('users.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:user-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Users</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('setting.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:settings-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Settings</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('penjualan.index') }}" aria-expanded="false">
                        <span>
                            <img src="{{ asset('assets/images/logos/kasir.png') }}" alt="Penjualan"
                                 class="sidebar-icon" style="width:20px; height:20px;">
                        </span>
                        <span class="hide-menu">Penjualan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporan.index') }}" aria-expanded="false">
                        <span>
                            <img src="{{ asset('assets/images/logos/report.png') }}" alt="Report"
                                 class="sidebar-icon" style="width:20px; height:20px;">
                        </span>
                        <span class="hide-menu">Laporan</span>
                    </a>
                </li>

                @endif

                {{-- KASIR MENU --}}
                @if(Auth::user()->Role == 'kasir')

                <!-- Home Section -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">Home</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard.index') }}" aria-expanded="false">
                        <span>
                            <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                 <!-- Menu Section -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                    <span class="hide-menu">Menu</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('pelanggan.index') }}" aria-expanded="false">
                        <span>
                            <img src="{{ asset('assets/images/logos/pelanggan.png') }}" alt="Pelanggan"
                                 class="sidebar-icon" style="width:20px; height:20px;">
                        </span>
                        <span class="hide-menu">Pelanggan</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('penjualan.index') }}" aria-expanded="false">
                        <span>
                            <img src="{{ asset('assets/images/logos/cash-register.SVG') }}" alt="Penjualan"
                                 class="sidebar-icon" style="width:20px; height:20px;">
                        </span>
                        <span class="hide-menu">Penjualan</span>
                    </a>
                </li>

                @endif
            </ul>
        </nav>
    </div>
</aside>


        @php
            use Illuminate\Support\Facades\Auth;
        @endphp

        <!-- Header -->
        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>

                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                            <!-- 🔔 Notifikasi -->
                            <li class="nav-item">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                    <i class="ti ti-bell-ringing"></i>
                                    <div class="notification bg-primary rounded-circle"></div>
                                </a>
                            </li>

                            <!-- 👤 User Dropdown -->
                            <li class="nav-item dropdown d-flex align-items-center">
                                <a href="#" class="text-decoration-none user-info d-flex align-items-center"
                                    id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                                    <!-- 🔥 Foto profil -->
                                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="User"
                                        class="rounded-circle me-2"
                                        style="width: 40px; height: 40px; object-fit: cover;">

                                    <!-- Detail Nama dan Role -->
                                    <div
                                        class="user-details d-none d-lg-flex flex-column align-items-start me-2">
                                        <span class="user-name fw-semibold">{{ Auth::user()->Nama }}</span>
                                        <span
                                            class="user-role text-muted small">{{ ucfirst(Auth::user()->Role) }}</span>
                                    </div>

                                    <i class="fas fa-chevron-down d-none d-lg-block"></i>
                                </a>

                                <!-- Dropdown Menu -->
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="userDropdown">
                                    <div class="message-body text-center">
                                        <div class="mb-2">
                                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                                                alt="User" class="rounded-circle mb-2"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <strong>{{ Auth::user()->Nama }}</strong><br>
                                                <small
                                                    class="text-muted">{{ ucfirst(Auth::user()->Role) }}</small>
                                            </div>
                                        </div>

                                        <form action="{{ route('logout') }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-outline-primary mx-3 mt-2 d-block">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    @yield('scripts')
</body>

</html>
