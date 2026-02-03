<?php

namespace App\Http\Controllers\Admin;

use App\Models\Siswa;
use App\Models\Aspirasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Admin',
            'aspirasi' => Aspirasi::orderBy('created_at', 'desc')->get(),
            'total_aspirasi' => Aspirasi::all()->count(),
            'aspirasi_menunggu' => Aspirasi::where('status', 'Menunggu')->get()->count(),
            'aspirasi_diproses' => Aspirasi::where('status', 'Diproses')->get()->count(),
            'aspirasi_selesai' => Aspirasi::where('status', 'Selesai')->get()->count(),
        ];


        return view('admin.dashboard', $data);
    }
}