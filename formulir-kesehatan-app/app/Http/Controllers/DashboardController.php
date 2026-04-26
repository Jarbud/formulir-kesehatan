<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PemeriksaanKesehatan;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($role === 'mahasiswa') {
            return view('mahasiswa.dashboard');
        }

        // Jika role tidak dikenali, kembalikan ke halaman utama atau logout
        return redirect('/');
    }

    public function adminDashboard()
    {
        $mahasiswas = User::where('role', 'mahasiswa')->latest()->get();
        return view('admin.dashboard', compact('mahasiswas'));
    }

    public function detailMahasiswa($id)
    {
        $mahasiswa = User::findOrFail($id);
        $riwayats = PemeriksaanKesehatan::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return view('admin.detail_mahasiswa', compact('mahasiswa', 'riwayats'));
    }
}
