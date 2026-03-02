@extends('admin.layouts.templates')

@section('content')
    <!-- CARDS STATISTIK -->
    <div class="row mb-4 card-wrapper">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-text">Total Aspirasi</p>
                    <h1 class="card-title">{{ $total_aspirasi }}</h1>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-text">Menunggu</p>
                    <h1 class="card-title">{{ $aspirasi_menunggu }}</h1>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-text">Diproses</p>
                    <h1 class="card-title">{{ $aspirasi_diproses }}</h1>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-text">Selesai</p>
                    <h1 class="card-title">{{ $aspirasi_selesai }}</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL ASPIRASI TERBARU -->
    <div class="table-responsive">
        <div class="table-box p-3 rounded">
            <h3 class="mb-3">Aspirasi Terbaru</h3>
            <table class="table table-dark table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th class="py-3 fw-bold text-white" style="white-space: nowrap;">Tanggal</th>
                        <th class="py-3 fw-bold text-white" style="white-space: nowrap;">Nama Siswa</th>
                        <th class="py-3 fw-bold text-white" style="white-space: nowrap;">Judul</th>
                        <th class="py-3 fw-bold text-white" style="white-space: nowrap;">Isi</th>
                        <th class="py-3 fw-bold text-white" style="white-space: nowrap;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aspirasi as $item)
                        <tr>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td>{{ $item->siswa->user->nama ?? '-' }}</td>
                            <td>{{ $item->judul ?? '-' }}</td>
                            <td >{{ $item->isi ?? '-' }}</td>
                            <td>
                                @php
                                    $statusClass = match ($item->status) {
                                        'menunggu' => 'status-menunggu',
                                        'diproses' => 'status-diproses',
                                        'selesai' => 'status-selesai',
                                        'ditolak' => 'status-ditolak',
                                        default => 'status-menunggu',
                                    };
                                @endphp
                                <span class="status {{ $statusClass }}">{{ ucfirst(strtolower($item->status)) }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
