<aside class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse" id="sidebarMenu">
    <div class="position-sticky pt-3">
        <div class="sidebar-header d-flex align-items-center mb-4">
            <img src="{{ asset('img/logo.png') }}" class="logo me-2">
            <span>Admin Panel</span>
        </div>

        <ul class="nav flex-column menu">
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.siswa') || request()->routeIs('admin.siswa.*') ? 'active' : '' }}"
                    href="{{ route('admin.siswa') }}">
                    <i class="fas fa-user-graduate me-2"></i> Kelola Siswa
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}" href="{{ route ('admin.kategori') }}">
                    <i class="fas fa-tags me-2"></i> Kategori
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.aspirasi*') ? 'active' : '' }}" href="{{ route ('admin.aspirasi') }}">
                    <i class="fas fa-envelope me-2"></i> Data Aspirasi
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}" href="{{ route ('admin.laporan') }}">
                    <i class="fa-regular fa-paper-plane"></i> Laporan
                </a>
            </li>
        </ul>
    </div>
</aside>
