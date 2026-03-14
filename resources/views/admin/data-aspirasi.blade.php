@extends('admin.layouts.templates')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4"
            style="background-color: #10b981; color: white;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-box">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center">NO</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($aspirasi as $item)
                        <tr>
                            <td class="text-center">
                                {{ $aspirasi->firstItem() + $loop->index }}
                            </td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>{{ $item->siswa->user->nama }}</td>
                            <td>{{ $item->judul }}</td>

                            <td>
                                @if ($item->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif ($item->status == 'diproses')
                                    <span class="badge bg-info text-dark">Diproses</span>
                                @elseif ($item->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    @if ($item->status == 'menunggu')
                                        {{-- TANGGAPI --}}
                                        <a href="#"
                                            class="btn btn-success btn-sm d-flex align-items-center justify-content-center gap-2 tombolEdit"
                                            style="width: 90px;" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-reply"></i> Tanggapi
                                        </a>
                                    @else
                                        {{-- UBAH STATUS --}}
                                        <a href="#"
                                            class="btn btn-primary btn-sm d-flex align-items-center justify-content-center gap-2 tombolEdit {{ $item->status == 'selesai' || $item->status == 'ditolak' ? 'disabled' : '' }}"
                                            style="width: 90px;" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-pen"></i> Ubah
                                        </a>
                                    @endif

                                    {{-- HAPUS --}}
                                    <a href="/admin/aspirasi/delete/aspirasi/{{ $item->id }}"
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center gap-2 {{ $item->status == 'menunggu' || $item->status == 'diproses' ? 'disabled' : '' }}"
                                        style="width: 90px;"
                                        onclick="if(this.classList.contains('disabled')) { return false; } return confirm('Yakin hapus aspirasi ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Tidak ada data aspirasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $aspirasi->links() }}
        </div>
    </div>


    {{-- modal tanggapan --}}

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tanggapan Aspirasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.tanggapan') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="aspirasi_id" id="aspirasi_id">
                        <input type="hidden" name="user_id" id="admin_id" value="{{ Auth()->user()->id }}">
                        <div class="form-group mb-3">
                            <label for="judul" class="form-label">Judul Aspirasi</label>
                            <textarea class="form-control" id="judul" rows="1" disabled></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="isi" class="form-label">Uraian Aspirasi</label>
                            <textarea class="form-control" id="isi" rows="3" disabled></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="isi_tanggapan" class="form-label">Isi Tanggapan</label>
                            <textarea name="isi_tanggapan" class="form-control" id="isi_tanggapan" rows="5" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Ubah Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Tanggapan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.tombolEdit').on('click', function() {
            const id = $(this).data('id');

            // Menggunakan AJAX untuk mendapatkan data aspirasi berdasarkan ID
            $.ajax({
                url: '/admin/get-aspirasi',
                method: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    userId: {{ Auth()->user()->id }},
                },
                success: function(data) {
                    // Mengisi data ke dalam modal
                    $('#aspirasi_id').val(data.aspirasi.id);
                    $('#judul').val(data.aspirasi.judul);
                    $('#isi').val(data.aspirasi.isi);
                    if (data.tanggapan) {
                        $('#isi_tanggapan').val(data.tanggapan.isi_tanggapan);
                        $('#status').val(data.aspirasi.status);
                    } else {
                        $('#isi_tanggapan').val('');
                        $('#status').val('');
                    }
                    if (data.aspirasi.status === 'menunggu') {
                        $('#status').val('');
                    } else {
                        $('#status').val(data.aspirasi.status);
                    }
                }
            });
        });
        $('#exampleModal').on('hidden.bs.modal', function() {
            // Bersihkan data modal saat ditutup
            location.reload();
        });
    </script>
@endsection
