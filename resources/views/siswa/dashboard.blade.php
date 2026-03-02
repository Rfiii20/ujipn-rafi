@extends('siswa.layouts.tamplates')

@section('content')
    <div class="main-content container-fluid pb-5">
        <div class="text-center mb-5">
            <div class="photo d-inline-block mb-3">
                <img src="{{ asset('img/rfi.jpg') }}" alt="Profile"
                    style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #f97316; box-shadow: 0 0 20px rgba(249, 115, 22, 0.3);">
            </div>
            <h2 style="color: #e5e7eb; font-weight: bold;">
                Selamat datang, <span style="color: #f97316;">{{ auth()->user()->nama }}</span>
                <br>
                <small style="color: #f97316;">Kelas: {{ auth()->user()->siswa->kelas }} {{ auth()->user()->siswa->jurusan }}
                </small>
            </h2>
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card p-3 border-0 shadow-sm" style="background: #1f2937; border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="fas fa-file-alt text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small">Total Aspirasi</p>
                            <h3 class="fw-bold mb-0 text-white">{{ $total_aspirasi }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3 border-0 shadow-sm" style="background: #1f2937; border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="fas fa-clock text-warning fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small">Menunggu</p>
                            <h3 class="fw-bold mb-0 text-white">{{ $aspirasi_menunggu }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3 border-0 shadow-sm" style="background: #1f2937; border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-success bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="fas fa-spinner text-success fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small">Diproses</p>
                            <h3 class="fw-bold mb-0 text-white">{{ $aspirasi_diproses }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card p-3 border-0 shadow-sm" style="background: #1f2937; border-radius: 15px;">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-info bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="fas fa-check-circle text-info fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small">Selesai</p>
                            <h3 class="fw-bold mb-0 text-white">{{ $aspirasi_selesai }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4"
                style="background-color: #10b981; color: white;">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('siswa.tambah-aspirasi') }}" class="btn btn-warning fw-bold px-4 py-2"
                style="background-color: #f97316; border: none; color: #fff;">
                <i class="fa-solid fa-plus me-2"></i> Ajukan Aspirasi Baru
            </a>
        </div>

        <div class="table-box p-4" style="background: #111827; border-radius: 15px;">
            <h3 class="mb-4" style="color: #f97316; font-weight: bold;">
                <i class="fas fa-history me-2"></i>Riwayat Aspirasi
            </h3>
            <table class="table table-dark table-hover border-0">
                <thead style="background: #1f2937;">
                    <tr>
                        <th class="border-0 py-3">NO</th>
                        <th class="border-0 py-3">Judul</th>
                        <th class="border-0 py-3">Kategori</th>
                        <th class="border-0 py-3">Detail Aduan</th>
                        <th class="border-0 py-3">Tanggal</th>
                        <th class="border-0 py-3 text-center">Status</th>
                        <th class="border-0 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="border-0">
                    @foreach ($aspirasi as $item)
                        <tr style="border-bottom: 1px solid #1f2937;">
                            <td>{{ $loop->iteration + ($aspirasi->currentPage() - 1) * $aspirasi->perPage() }}</td>
                            <td class="py-3 fw-bold text-white">{{ $item->judul }}</td>
                            <td class="py-3">
                                <span
                                    class="badge bg-solid border border-secondary text-light">{{ $item->kategori->nama_kategori }}</span>
                            </td>
                            <td class="py-3 text-muted small">{{ Str::limit($item->isi, 40) }}</td>
                            <td class="py-3">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="py-3 text-center">
                                <span class="status status-{{ strtolower($item->status) }}" style="font-size: 11px;">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($item->tanggapan->count() > 0)
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modalBalasan{{ $item->id }}">
                                        <i class="fas fa-comment-dots"></i> Lihat Balasan ({{ $item->tanggapan->count() }})
                                    </button>

                                    <div class="modal fade" id="modalBalasan{{ $item->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-dark text-white border-secondary">
                                                <div class="modal-header border-secondary">
                                                    <h5 class="modal-title text-warning"><i
                                                            class="fas fa-reply-all me-2"></i>Tanggapan Admin</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <label class="text-muted small">Aspirasi Anda:</label>
                                                    <p class="mb-3">"{{ $item->isi }}"</p>
                                                    <hr class="border-secondary">

                                                    <label class="text-warning small mb-2">Jawaban Admin:</label>
                                                    {{-- LOOPING HASMANY --}}
                                                    @foreach ($item->tanggapan as $balasan)
                                                        <div
                                                            class="p-3 rounded bg-secondary bg-opacity-25 mb-3 border-start border-success border-4">
                                                            <p class="mb-1 text-light">{{ $balasan->isi_tanggapan }}</p>
                                                            <div class="mt-2 d-flex justify-content-between opacity-75"
                                                                style="font-size: 10px;">
                                                                <span><i class="fas fa-user-edit"></i>
                                                                    {{ $balasan->user->nama }}</span>
                                                                <span><i class="fas fa-calendar"></i>
                                                                    {{ $balasan->created_at->format('d M Y') }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- JIKA BELUM ADA TANGGAPAN, TAMPILKAN TOMBOL EDIT & HAPUS --}}
                                    <a href="/siswa/aspirasi/edit/{{ $item->id }}"
                                        class="btn btn-sm btn-info {{ $item->status != 'menunggu' ? 'disabled' : '' }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="/siswa/aspirasi/delete/{{ $item->id }}"
                                        class="btn btn-sm btn-danger {{ $item->status != 'menunggu' ? 'disabled' : '' }}"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                @endif
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4" style="gap-20px !impor">
                {{ $aspirasi->links() }}
            </div>
        </div>
    </div>
@endsection
