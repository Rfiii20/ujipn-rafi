@extends('admin.layouts.templates')

@section('content')
    <div class="shadow p-3">
        <h3 class="text-center mb-4">FORM EDIT DATA KATEGORI</h3>
        <p class="lead mb-3">Silahkan isi data dalam for di bawah ini dengan benar :</p>

        <form action="{{ route('admin.edit-kategori') }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" value="{{ $kategori->id }}">

            <div class="form-group row mb-3 align-items-center">
                <label for="nama_kategori" class="form-label col-3">Nama Kategori</label>
                <div class="col-9">
                    <input type="text" name="nama_kategori"
                        class="form-control @error('nama_kategori') is-invalid @enderror"
                        placeholder="nama_kategori Siswa ..." value="{{ old('nama_kategori', $kategori->nama_kategori) }}">

                    @error('nama_kategori')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-3 align-items-center">
                <label for="deskripsi" class="form-label col-3">Deskripsi</label>
                <div class="col-9">
                    <input type="text" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                        placeholder="deskripsi ..." value="{{ old('deskripsi', $kategori->deskripsi) }}">

                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-success px-5" type="submit">
                    <i class="fas fa-edit"></i> Simpan
                </button>
                <a href="{{ route('admin.kategori') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-undo"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection




Edit kategori
