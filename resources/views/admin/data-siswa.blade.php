@extends('admin.layouts.templates')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
            style="background-color: #10b981; color: white;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
            style="background-color: #ef4444; color: white;">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- Langsung pakai table-box agar lebar mengikuti kolom utama --}}
    <div class="table-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-orange mb-0"><i class="fas fa-users me-2"></i>Data Siswa</h3>
            <a href="{{ route('admin.tambah-siswa') }}" class="btn btn-success">
                <i class="fa-solid fa-plus me-1"></i> Tambah Data Siswa
            </a>
        </div>

        <div class="table-responsive">
            {{-- Gunakan table-dark agar background otomatis sinkron dengan dashboard --}}
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center">NO</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->nis }}</td>
                            <td>{{ $item->user->nama }}</td>
                            {{-- Jangan pakai text-muted di sini agar email terlihat putih --}}
                            <td>{{ $item->user->email }}</td>
                            <td>{{ $item->kelas }} {{ $item->jurusan }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.siswa-edit', $item->id) }}" class="btn btn-primary btn-sm me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.siswa-delete', $item->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm @if ($item->aspirasi->count() > 0) disabled @endif"
                                        onclick="return confirm('Yakin hapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
