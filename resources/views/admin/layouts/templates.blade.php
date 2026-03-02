<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100">

            @include('admin.layouts.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 content">
                <div class="d-flex justify-content-between align-items-center mb-4 header">
                    <div class="d-flex align-items-center">
                        <i class=" me-2 text-warning" style="font-size:22px;"></i>
                        <h2 class="m-0">{{ $title }}</h2>
                    </div>


                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle d-flex align-items-center" type="button"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i> {{ Auth::user()->nama }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('js/jquery-4.0.0.min.js') }}"></script>
    @yield('script')
</body>

</html>
