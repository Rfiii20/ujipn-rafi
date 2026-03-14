<?php

namespace App\Http\Controllers\Siswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Kategori;

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

    public function editAspirasi($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        $data = [
            'aspirasi' => $aspirasi,
            'kategori' => Kategori::all(),
        ];

        return view('siswa.edit-aspirasi', $data);
    }
    public function updateAspirasi(Request $request, $id)
    {
        $aspirasi = Aspirasi::find($id);

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

    public function cekNotifSiswa()
    {
        $siswa_id = auth()->user()->siswa->id;

        $jumlah = Aspirasi::where('siswa_id', $siswa_id)->has('tanggapan')->count();

        return response()->json([
            'jumlah' => $jumlah
        ]);
    }

    public function gettanggapan(Request $request)
    {
        $id = $request->id;
        $aspirasi = Aspirasi::with(['tanggapan' => function ($query) {
            $query->latest();
        }, 'tanggapan.user'])->find($id);

        if ($aspirasi) {
            $dataTanggapan = [];

            if ($aspirasi->status == 'selesai' || $aspirasi->status == 'ditolak') {
                $tanggapanTerakhir = $aspirasi->tanggapan->first();
                $dataTanggapan = $tanggapanTerakhir ? [$tanggapanTerakhir] : [];
            } else {
                $dataTanggapan = $aspirasi->tanggapan;
            }

            return response()->json([
                'isi_aspirasi'    => $aspirasi->isi,
                'status_aspirasi' => $aspirasi->status,
                'tanggapan'       => $dataTanggapan
            ]);
        }

        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }
}
