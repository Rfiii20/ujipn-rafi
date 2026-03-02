<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'nama' => User::find(auth()->user()->id)->nama,
            'title' => 'Dashboard Admin',
            'aspirasi' => Aspirasi::orderBy('created_at', 'desc')->get(),
            'total_aspirasi' => Aspirasi::all()->count(),
            'aspirasi_menunggu' => Aspirasi::where('status', 'Menunggu')->count(),
            'aspirasi_diproses' => Aspirasi::where('status', 'Diproses')->count(),
            'aspirasi_selesai' => Aspirasi::where('status', 'Selesai')->count(),
            'totalSiswa' => Siswa::count(),  // <--- tambahkan ini
        ];

        return view('admin.dashboard', $data);
    }
}
