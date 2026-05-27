<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PemeriksaanKesehatan;
use App\Models\Faculty;

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

        if ($role === 'perawat') {
            return redirect()->route('perawat.dashboard');
        }

        if ($role === 'dokter') {
            return redirect()->route('dokter.dashboard');
        }

        // Jika role tidak dikenali, kembalikan ke halaman utama atau logout
        return redirect('/');
    }

    public function adminDashboard()
    {
        // Mengelompokkan data berdasarkan fakultas dari tabel pemeriksaan_kesehatans
        $fakultas = PemeriksaanKesehatan::select('fakultas', DB::raw('count(distinct user_id) as total_mahasiswa'))
            ->groupBy('fakultas')
            ->get();

        return view('admin.dashboard', compact('fakultas'));
    }

    public function prodiByFakultas($fakultas)
    {
        // Mengelompokkan data berdasarkan prodi dari fakultas terkait
        $prodis = PemeriksaanKesehatan::select('prodi', DB::raw('count(distinct user_id) as total_mahasiswa'))
            ->where('fakultas', $fakultas)
            ->groupBy('prodi')
            ->get();

        return view('admin.prodi_fakultas', compact('fakultas', 'prodis'));
    }

    public function mahasiswaByProdi($fakultas, $prodi)
    {
        // Mengambil mahasiswa yang mengajukan pemeriksaan di prodi dan fakultas tersebut
        $pemeriksaans = PemeriksaanKesehatan::where('fakultas', $fakultas)
            ->where('prodi', $prodi)
            ->latest()
            ->get()
            ->unique('user_id');
            
        return view('admin.mahasiswa_fakultas', compact('pemeriksaans', 'fakultas', 'prodi'));
    }

    public function detailMahasiswa($id)
    {
        $mahasiswa = User::findOrFail($id);
        $riwayats = PemeriksaanKesehatan::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return view('admin.detail_mahasiswa', compact('mahasiswa', 'riwayats'));
    }

    public function ttdPemeriksaan($id)
    {
        $pemeriksaan = PemeriksaanKesehatan::findOrFail($id);
        $pemeriksaan->status_proses = 'selesai';
        $pemeriksaan->save();

        return redirect()->back()->with('success', 'Dokumen berhasil ditandatangani dan diselesaikan.');
    }

    public function validasiNakes($id)
    {
        // Pengecekan apabila scan berasal dari "Dokter Penanggungjawab" yang ID nya dibuat statis (pj)
        if ($id === 'pj') {
            $nakes = (object) [
                'name' => 'dr. Ifa mufida, MMRS',
                'nip' => '440.1/0928/35.73.406/2023',
                'role' => 'Dokter Penanggungjawab'
            ];
        } else {
            $user = User::findOrFail($id);
            $nakes = (object) [
                'name' => $user->name,
                'nip' => $user->nip ?? '-',
                'role' => 'Dokter Pemeriksa'
            ];
        }

        return view('validasi_nakes', compact('nakes'));
    }

    public function exportExcel($id)
    {
        $data = PemeriksaanKesehatan::findOrFail($id);

        $filename = "Pemeriksaan_Kesehatan_" . $data->nim . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID', 'User ID', 'Nama Lengkap', 'NIK', 'NIM', 'Jenis Kelamin', 'Usia', 'Fakultas', 'Prodi', 
            'Tempat Tanggal Lahir', 'Alamat Asal', 'Alamat Malang', 'WA', 'Nama Wali', 'WA Wali', 
            'Disabilitas', 'Tinggi Badan', 'Berat Badan', 'IMT', 'Riwayat Sakit', 
            'Riwayat Kesehatan Fisik', 'Keluhan', 'Status Pembayaran', 'Tanggal Pengajuan'
        ];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $row = [
                $data->id,
                $data->user_id,
                $data->name,
                $data->nik,
                $data->nim,
                $data->jenis_kelamin,
                $data->usia,
                $data->fakultas,
                $data->prodi,
                $data->tempat_tanggal_lahir,
                $data->alamat_asal,
                $data->alamat_malang,
                $data->wa,
                $data->nama_wali,
                $data->wa_wali,
                $data->disabilitas,
                $data->tinggi_badan,
                $data->berat_badan,
                $data->imt,
                $data->riwayat_sakit,
                $data->riwayat_kesehatan_fisik,
                $data->keluhan,
                $data->status_pembayaran,
                $data->created_at ? $data->created_at->format('Y-m-d H:i:s') : ''
            ];

            fputcsv($file, $row);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcelAll()
    {
        $data = PemeriksaanKesehatan::orderBy('created_at', 'desc')->get();

        $filename = "Semua_Data_Pemeriksaan_Kesehatan.csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID', 'User ID', 'Nama Lengkap', 'NIK', 'NIM', 'Jenis Kelamin', 'Usia', 'Fakultas', 'Prodi', 
            'Tempat Tanggal Lahir', 'Alamat Asal', 'Alamat Malang', 'WA', 'Nama Wali', 'WA Wali', 
            'Disabilitas', 'Tinggi Badan', 'Berat Badan', 'IMT', 'Riwayat Sakit', 
            'Riwayat Kesehatan Fisik', 'Keluhan', 'Status Pembayaran', 'Tanggal Pengajuan'
        ];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $item) {
                $row = [
                    $item->id,
                    $item->user_id,
                    $item->name,
                    $item->nik,
                    $item->nim,
                    $item->jenis_kelamin,
                    $item->usia,
                    $item->fakultas,
                    $item->prodi,
                    $item->tempat_tanggal_lahir,
                    $item->alamat_asal,
                    $item->alamat_malang,
                    $item->wa,
                    $item->nama_wali,
                    $item->wa_wali,
                    $item->disabilitas,
                    $item->tinggi_badan,
                    $item->berat_badan,
                    $item->imt,
                    $item->riwayat_sakit,
                    $item->riwayat_kesehatan_fisik,
                    $item->keluhan,
                    $item->status_pembayaran,
                    $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : ''
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function laporanIndex()
    {
        $faculties = Faculty::with('programStudis')->get();
        return view('admin.laporan', compact('faculties'));
    }

    public function exportLaporan(Request $request)
    {
        $query = PemeriksaanKesehatan::query();

        // Filter by Fakultas
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        // Filter by Program Studi
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        // Filter by Waktu
        if ($request->filled('filter_waktu')) {
            if ($request->filter_waktu === 'harian' && $request->filled('tanggal')) {
                $query->whereDate('created_at', $request->tanggal);
            } elseif ($request->filter_waktu === 'bulanan' && $request->filled('bulan') && $request->filled('tahun')) {
                $query->whereMonth('created_at', $request->bulan)
                      ->whereYear('created_at', $request->tahun);
            } elseif ($request->filter_waktu === 'tahunan' && $request->filled('tahun')) {
                $query->whereYear('created_at', $request->tahun);
            }
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = "Laporan_Kesehatan_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID', 'User ID', 'Nama Lengkap', 'NIK', 'NIM', 'Jenis Kelamin', 'Usia', 'Fakultas', 'Prodi', 
            'Tempat Tanggal Lahir', 'Alamat Asal', 'Alamat Malang', 'WA', 'Nama Wali', 'WA Wali', 
            'Disabilitas', 'Tinggi Badan', 'Berat Badan', 'IMT', 'Riwayat Sakit', 
            'Riwayat Kesehatan Fisik', 'Keluhan', 'Status Pembayaran', 'Tanggal Pengajuan', 'Status Proses', 'Kesimpulan', 'Rekomendasi'
        ];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $item) {
                $row = [
                    $item->id, $item->user_id, $item->name, $item->nik, $item->nim, $item->jenis_kelamin, $item->usia, $item->fakultas, $item->prodi, 
                    $item->tempat_tanggal_lahir, $item->alamat_asal, $item->alamat_malang, $item->wa, $item->nama_wali, $item->wa_wali, 
                    $item->disabilitas, $item->tinggi_badan, $item->berat_badan, $item->imt, $item->riwayat_sakit, 
                    $item->riwayat_kesehatan_fisik, $item->keluhan, $item->status_pembayaran, $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : '',
                    $item->status_proses, $item->kesimpulan, $item->rekomendasi
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function rangkumanPemeriksaan()
    {
        // Menggabungkan (join) tabel untuk mendapatkan nama Perawat dan total pemeriksaannya
        $perawatSummary = DB::table('pemeriksaan_kesehatans')
            ->join('users', 'pemeriksaan_kesehatans.id_perawat_acc', '=', 'users.id')
            ->select('users.name', DB::raw('count(pemeriksaan_kesehatans.id) as total'))
            ->whereNotNull('id_perawat_acc')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->get();

        // Menggabungkan (join) tabel untuk mendapatkan nama Dokter dan total pemeriksaannya
        $dokterSummary = DB::table('pemeriksaan_kesehatans')
            ->join('users', 'pemeriksaan_kesehatans.id_dokter_acc', '=', 'users.id')
            ->select('users.name', DB::raw('count(pemeriksaan_kesehatans.id) as total'))
            ->whereNotNull('id_dokter_acc')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->get();

        return view('admin.rangkuman', compact('perawatSummary', 'dokterSummary'));
    }
}
