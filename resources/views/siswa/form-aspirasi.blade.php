@extends('siswa.layouts.tamplates')

@section('content')
    <div class="main-content min-vh-100">
        <div class="box shadow p-5">
            <h2 class="text-center mb-4">Form Pengaduan Aspirasi</h2>
            <p class="lead fst-italic">Isi Data Dibawah Ini Dengan Benar</p>
            <form action="{{ route('siswa.proses-tambah') }}" method="POST">
                @csrf
                <input type="hidden" name="siswa_id" value="{{ auth()->user()->siswa->id }}">
                <div class="form-group row mb-3">
                    <label for="nama_siswa" class="col-3">Nama Siswa</label>
                    <div class="col-9">
                        <input type="text" name="nama_siswa" id="" value="{{ auth()->user()->nama }}" disabled
                            class="form-control" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="kelas" class="col-3">Kelas</label>
                    <div class="col-9">
                        <input type="text" name="kelas" id="" value="{{ auth()->user()->siswa->kelas }}"
                            disabled class="form-control" required>
                    </div>
                </div>
                <div class="form-group row mb-3 d-flex align-items-center">
                    <label for="kategori_id" class="col-3">Kategori</label>
                    <div class="col-9">
                        <select name="kategori_id" @error('kategori_id') is-invalid @enderror class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="judul" class="col-3">Judul</label>
                    <div class="col-9">
                        <input type="text" class="form-control" @error('judul') is-invalid @enderror name="judul" id="" required>
                        @error('judul')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                    <div class="form-group row mb-3 d-flex align-items-center">
                        <label for="isi" class="col-3">Isi Pesan</label>
                        <div class="col-9">
                            <textarea name="isi" id="" rows="10" class="form-control" @error('isi') is-invalid @enderror required   ></textarea>
                            @error('isi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save">Proses Ajuan</i></button>
                        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary"><i
                                class="fas fa-close">Cancel</i></a>
                    </div>
            </form>
        </div>
    </div>
@endsection
