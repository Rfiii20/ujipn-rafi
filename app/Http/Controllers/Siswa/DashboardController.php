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
            'aspirasi' => Aspirasi::where('siswa_id', $siswa_id)->get(),
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
        return redirect()->route('siswa.dashboard');
    }
}
