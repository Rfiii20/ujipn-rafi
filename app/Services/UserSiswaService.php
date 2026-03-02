<?php
namespace App\Services;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSiswaService
{
    public function create(array $data)
    {
        return DB::transaction(function () use ($data){
            $user = User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'username' => 'user-' . $data['nama'],
                'password' => bcrypt('12345'),
                'role' => 'siswa',
            ]);

            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nis' => $data('nis'),
                'kelas' => $data('kelas'),
                'jurusan' => $data('jurusan'),
            ]);

            return $user->load('siswa');
        });
    }

    public function delete(Siswa $siswa)
    {
        return DB::transaction(function () use ($siswa) {
            // hapus data siswa berdasarkan user_id terkait
            User::find($siswa->user_id)->delete();

            // hapus data siswa berdasarkan id_siswa
            $siswa::find($siswa->id)->delete();
        });
    }
}