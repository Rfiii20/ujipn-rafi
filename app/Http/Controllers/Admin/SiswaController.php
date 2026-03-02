<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiswaController extends Controller
{
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
                'nis.digits'    => 'NIS harus 8 angka.',
                'nis.unique'    => 'NIS sudah digunakan.',

                'email.required' => 'Email wajib diisi.',
                'email.email'   => 'Format email tidak valid.',
                'email.unique'  => 'Email sudah digunakan.',
            ]
        );

        $username = explode('@', $validatedData['email'])[0];

        // 1️⃣ Buat user & SIMPAN ke variabel
        $user = User::create([
            'nama'     => $validatedData['nama'],
            'username' => $username,
            'email'    => $validatedData['email'],
            'password' => bcrypt('password123'),
            'role'     => 'siswa',
        ]);

        // 2️⃣ Tambahin user_id ke data siswa
        $validatedData['user_id'] = $user->id;

        // 3️⃣ Buang field yang bukan milik tabel siswa
        unset($validatedData['nama'], $validatedData['email']);

        // 4️⃣ Simpan siswa (INI BARU BENAR)
        Siswa::create($validatedData);

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // hapus siswa dulu
        $siswa->delete();

        // hapus user yang terkait
        User::where('id', $siswa->user_id)->delete();

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

        // Proses update menggunakan service atau langsung
        // Contoh jika langsung:
        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
        ]);

        $siswa->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }
}
