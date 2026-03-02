@extends('siswa.layouts.tamplates')

@section('content')
    <div class="main-content min-vh-100" style="background: #111827; border-radius: 15px;">
        <div class="box shadow p-5">
            <h2 class="text-center mb-4" style="color: #f97316;">Edit Aspirasi</h2>
            <p class="lead fst-italic text-white">Perbarui data aspirasi kamu di bawah ini</p>

            <form action="{{ route('siswa.update-aspirasi', $aspirasi->id) }}" method="POST">
                @csrf
                <input type="hidden" name="siswa_id" value="{{ auth()->user()->siswa->id }}">

                <div class="form-group row mb-3">
                    <label for="nama_siswa" class="col-3 text-white">Nama Siswa</label>
                    <div class="col-9">
                        <input type="text" value="{{ auth()->user()->nama }}" disabled
                            class="form-control bg-dark text-white border-secondary">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="kategori_id" class="col-3 text-white">Kategori</label>
                    <div class="col-9">
                        <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}"
                                    {{ $aspirasi->kategori_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="judul" class="col-3 text-white">Judul</label>
                    <div class="col-9">
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                            value="{{ old('judul', $aspirasi->judul) }}" required>
                    </div>
                </div>

                <div class="form-group row mb-3 d-flex align-items-center">
                    <label for="isi" class="col-3 text-white">Isi Pesan</label>
                    <div class="col-9">
                        <textarea name="isi" rows="10" class="form-control @error('isi') is-invalid @enderror" required>{{ old('isi', $aspirasi->isi) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-warning fw-bold text-white"
                        style="background-color: #f97316; border: none;">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-close"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
