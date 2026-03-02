@extends('admin.layouts.templates')

@section('content')
    {{-- ALERT --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4"
            style="background-color: #10b981; color: white;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="table-box">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-orange mb-0">Data Kategori</h3>

            <a href="{{ route('admin.form-kategori') }}" class="btn btn-success px-4">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>


        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center">NO</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($kategori as $index => $kat)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $kat->nama_kategori }}</td>
                            <td class="text-light">{{ $kat->deskripsi }}</td>
                            <td class="text-center">

                                {{-- EDIT --}}
                                <a href="/admin/kategori/edit/{{ $kat->id }}" class="btn btn-primary btn-sm me-1"><i
                                        class="fas fa-edit"></i> Edit</a>

                                {{-- DELETE --}}
                                <a href="/admin/kategori/delete/{{ $kat->id }}"class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin data kategori ini akan dihapus?')">
                                    <i class="fas fa-trash"></i> Hapus </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Tidak ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
