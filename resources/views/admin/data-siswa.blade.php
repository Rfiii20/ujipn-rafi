@extends('admin.layouts.templates')

@section('content')
    <div class="card shadow-sm border-0 p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="">NO</th>
                        <th class="">NISN</th>
                        <th class="">Nama Siswa</th>
                        <th class="">Email</th>
                        <th class="">Kelas</th>
                        <th class=" text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="">{{ $item->nis }}</span></td>
                            <td class="">{{ $item->user->nama }}</td>
                            <td class="text-muted small">{{ $item->user->email }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td class="text-center">
                                <a href="#" class="btn  btn-primary btn-sm"><i class="fas fa-edit m-1"></i>Tanggapi</a>
                                <a href="#" class="btn  btn-danger btn-sm"><i class="fas fa-trash me-1"></i>Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
