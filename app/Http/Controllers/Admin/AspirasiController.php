<?php

namespace App\Http\Controllers\Admin;

use App\Models\Aspirasi;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use App\Services\TanggapanAspirasi;
use App\Http\Controllers\Controller;


class AspirasiController extends Controller
{
    public function __construct(
        private TanggapanAspirasi $service
    ){}

    public function index()
    {
        $data = [
            'title' => 'Data Aspirasi Siswa',
            'aspirasi' => Aspirasi::with('siswa.user', 'kategori')->orderByRaw("CASE
                WHEN status = 'selesai' THEN 4
                WHEN status = 'ditolak' THEN 3
                WHEN status = 'diproses' THEN 2
                WHEN status = 'menunggu' THEN 1
            END")
            ->latest('id')->paginate(5)
        ];

        return view('admin.data-aspirasi', $data);
    }

    public function getTanggapanByAspirasi(Request $request)
    {
        $tanggapan = Tanggapan::where([
            'aspirasi_id'=> $request->id,
            'user_id'=> $request->userId])->get();

    $aspirasi = Aspirasi::find($request->id);

    $data = [
        'tanggapan' => $tanggapan,
        'aspirasi' => $aspirasi
    ];

        return $data;
    }

    public function addTanggapan(Request $request)
    {
        try {
            $this->service->addTanggapan($request->all());
            return redirect()->route('admin.aspirasi')->with('success', 'Tanggapan berhasil ditambahkan');
        } catch (\Throwable $e) {
            return redirect()->route('admin.aspirasi')->with('error', 'Tanggapan gagal ditambahkan: ');
        }
    }


    public function delete(Aspirasi $aspirasi)
    {
        try {
            $this->service->delete($aspirasi);
            return redirect()->route('admin.aspirasi')->with('success', 'Aspirasi berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->route('admin.aspirasi')->with('error', ' gagal menghapus aspirasi ');
        }
    }


    public function cekNotif()
    {
        $jumlah = Aspirasi::doesntHave('tanggapan')->count();

        return response()->json([
            'jumlah' => $jumlah
        ]);
    }


}
