<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
</head>

<body class="bg-dark-custom">
    <div class="container-fluid min-vh-100">
        <main class="mx-auto" style="max-width:1100px; padding-top: 20px;">

            <div class="d-flex justify-content-between align-items-center mb-4 header-siswa py-3 px-4 shadow-sm">
                <div class="d-flex align-items-center">
                    <a href="{{ route ('siswa.dashboard') }}" class="d-flex align-items-center text-decoration-none" >
                        <i class="fas fa-bars text-warning me-3" style="font-size: 20px; cursor: pointer;"></i>
                        <h2 class="m-0 " style="color: orange !important;" >Dashboard Siswa</h2>
                    </a>
                </div>

                <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle d-flex align-items-center" type="button"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>
                        <span>{{ auth()->user()->username }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-right-from-bracket me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

                @if (session('succes'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4"
            style="background-color: #10b981; color: white;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

            <div class="content-area">
                @yield('content')
            </div>

        </main>
    </div>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
