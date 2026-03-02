@extends('admin.layouts.templates')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card-wrapper">
                <div class="card shadow-sm border-0 p-4">
                    <div class="card-header bg-transparent border-0 pb-3">
                        <h4 class="text-orange mb-0"><i class="fas fa-user-plus me-2"></i>Form Tambah Siswa</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.proses-tambah') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nis" class="form-label text-light fw-semibold">NISN</label>
                                    <input type="text"
                                        class="form-control bg-dark text-light border-secondary @error('nis') is-invalid @enderror"
                                        id="nis" name="nis" inputmode="numeric" pattern="[0-9]*" maxlength="8"
                                        placeholder="Masukkan 8 digit NISN" required>
                                    @error('nis')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label text-light fw-semibold">Nama Siswa</label>
                                    <input type="text" class="form-control bg-dark text-light border-secondary"
                                        id="nama" name="nama" inputmode="text" placeholder="Masukkan Nama Siswa"
                                        required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label text-light fw-semibold">Email</label>
                                    <input type="email"
                                        class="form-control bg-dark text-light border-secondary @error('email') is-invalid @enderror"
                                        id="email" name="email" inputmode="email" placeholder="Masukkan Email Siswa"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kelas" class="form-label text-light fw-semibold">Kelas</label>
                                    <select class="form-control bg-dark text-light border-secondary" id="kelas"
                                        name="kelas" required>
                                        <option value="">Pilih Kelas</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jurusan" class="form-label text-light fw-semibold">Jurusan</label>
                                    <select class="form-control bg-dark text-light border-secondary" id="jurusan"
                                        name="jurusan" required>
                                        <option value="">Pilih Jurusan</option>
                                        <option value="RPL">Rekayasa Perangkat Lunak (RPL)</option>
                                        <option value="UPW">Usaha Perjalanan Wisata (UPW)</option>
                                        <option value="BR">Bisnis Retail (BR)</option>
                                        <option value="MP">Manajemen Perkantoran (MP)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-warning me-3"><i class="fa-solid fa-save me-1"></i>
                                    Simpan</button>
                                <a href="#" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
