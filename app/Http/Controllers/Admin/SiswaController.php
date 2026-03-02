<?php

namespace App\Http\Controllers\Admin;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserSiswaService; // Pastikan Service di-import di sini

class SiswaController extends Controller
{
    // Tambahkan constructor supaya service bisa dipanggil di semua method
    protected $siswaService;

    public function __construct(UserSiswaService $siswaService)
    {
        $this->siswaService = $siswaService;
    }

    public function index()
    {
        $data = [
            'title' => 'Data Siswa',
            'siswa' => Siswa::all(),
        ];
        return view('admin.data-siswa', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Siswa',
        ];
        return view('admin.form-siswa', $data);
    }

    public function tambahSiswa(Request $request)
    {
        // Validasi data tetap di Controller
        $validatedData = $request->validate(
            [
                'nis'     => 'required|integer|digits:8|unique:siswa,nis',
                'nama'    => 'required|string|max:255',
                'email'   => 'required|email|unique:users,email',
                'kelas'   => 'required|string',
                'jurusan' => 'required|string',
            ],
            [
                'nis.required'   => 'NIS wajib diisi.',
                'nis.digits'     => 'NIS harus 8 angka.',
                'nis.unique'     => 'NIS sudah digunakan.',
                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email sudah digunakan.',
            ]
        );

        // Panggil Service untuk logic pembuatannya (Gak perlu bikin manual di sini)
        $this->siswaService->create($validatedData);

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Panggil logic hapus dari Service milikmu
        $this->siswaService->delete($siswa);

        return redirect()->route('admin.siswa')
            ->with('success', 'Data siswa berhasil dihapus!');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        $data = [
            'title' => 'Edit Siswa',
            'siswa' => $siswa,
        ];

        return view('admin.edit-siswa', $data);
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nis' => 'required|max:8',
            'nama' => 'required',
            'email' => 'required|email',
        ]);

        $siswa = Siswa::findOrFail($id);

        // Update data Siswa
        $siswa->update([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
        ]);

        // Update data User terkait
        $siswa->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }
}