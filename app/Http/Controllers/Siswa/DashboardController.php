<?php

namespace App\Http\Controllers\Siswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa_id = auth()->user()->siswa->id;
        $data = [
            'aspirasi' => Aspirasi::where('siswa_id', $siswa_id)->paginate(5),
            'total_aspirasi' => Aspirasi::where('siswa_id', $siswa_id)->get()->count(),
            'aspirasi_menunggu' => Aspirasi::where([
                'siswa_id' => $siswa_id,
                'status' => 'menunggu'
            ])->get()->count(),
            'aspirasi_diproses' => Aspirasi::where([
                'siswa_id' => $siswa_id,
                'status' => 'diproses'
            ])->get()->count(),
            'aspirasi_selesai' => Aspirasi::where([
                'siswa_id' => $siswa_id,
                'status' => 'selesai'
            ])->get()->count(),
        ];

        return view('siswa.dashboard', $data);
    }

    public function tambahAspirasi()
    {
        $data = [
            'kategori' => Kategori::all(),
        ];
        return view('siswa.form-aspirasi', $data);
    }

    public function simpanAspirasi(request $request)
    {
        $validatedData = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kategori_id' => 'required|exists:kategori,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ], [
            'siswa_id.required' => 'ID siswa wajib diisi.',
            'siswa_id.exists' => 'ID siswa tidak valid.',
            'kategori_id.required' => 'Kategori wajib diisi.',
            'kategori_id.exists' => 'Kategori tidak valid.',
            'judul.required' => 'Judul wajib diisi.',
            'judul.string' => 'Judul harus berupa teks.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'isi.required' => 'Isi aspirasi wajib diisi.',
            'isi.string' => 'Isi aspirasi harus berupa teks.',
        ]);
        $validatedData['status'] = 'menunggu';

        Aspirasi::create($validatedData);
        return redirect()->route('siswa.dashboard')->with('success', 'Aspirasi berhasil ditambahkan!');
    }

    // 1. Fungsi untuk menampilkan halaman edit
    public function editAspirasi($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        // Keamanan: Pastikan siswa hanya bisa edit aspirasi miliknya sendiri
        if ($aspirasi->siswa_id != auth()->user()->siswa->id) {
            return redirect()->route('siswa.dashboard')->with('error', 'Akses dilarang!');
        }

        $data = [
            'aspirasi' => $aspirasi,
            'kategori' => Kategori::all(),
        ];

        return view('siswa.edit-aspirasi', $data);
    }

    // 2. Fungsi untuk memproses update data ke database
    public function updateAspirasi(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $aspirasi->update($validatedData);

        return redirect()->route('siswa.dashboard')->with('success', 'Aspirasi berhasil diperbarui!');
    }

    public function delete(Aspirasi $aspirasi)
    {
        $aspirasi->delete();
        return redirect()->route('siswa.dashboard')->with('success', 'Data Aspirasi berhasil dihapus di dalam database');
    }
}