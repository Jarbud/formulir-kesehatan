<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PemeriksaanKesehatan;

class DashboardController extends Controller
{
    //
    public function adminDashboard()
    {
        // Mengelompokkan data berdasarkan fakultas dari tabel pemeriksaan_kesehatans
        $fakultas = PemeriksaanKesehatan::select('fakultas', DB::raw('count(distinct user_id) as total_mahasiswa'))
            ->where('status_proses', 'perawat')
            ->groupBy('fakultas')
            ->get();

        return view('perawat.dashboard', compact('fakultas'));
    }

    public function mahasiswaByFakultas($fakultas)
    {
        // Mengambil mahasiswa yang mengajukan pemeriksaan di fakultas tersebut dan berstatus 'perawat'
        $pemeriksaans = PemeriksaanKesehatan::where('fakultas', $fakultas)
            ->where('status_proses', 'perawat') // Menambahkan filter status_proses
            ->latest()
            ->get()
            ->unique('user_id');

        return view('perawat.mahasiswa_fakultas', compact('pemeriksaans', 'fakultas'));
    }

    public function detailMahasiswa($id)
    {
        $mahasiswa = User::findOrFail($id);
        $riwayats = PemeriksaanKesehatan::where('user_id', $id)->where('status_proses', 'perawat')->orderBy('created_at', 'desc')->get();
        return view('perawat.detail_mahasiswa', compact('mahasiswa', 'riwayats'));
    }

    public function updatePemeriksaan(Request $request, $id)
    {
        $request->validate([
            'tekanan_darah' => 'required',
            'ishihara' => 'required|in:+,-,parsial',
            'lingkar_perut' => 'nullable|numeric',
            'gula_darah' => 'nullable|numeric',
            'visus_mata' => 'required|in:Normal,Gangguan',
        ]);

        $pemeriksaan = PemeriksaanKesehatan::findOrFail($id);
        $pemeriksaan->tekanan_darah = $request->tekanan_darah;
        $pemeriksaan->ishihara = $request->ishihara;
        $pemeriksaan->lingkar_perut = $request->lingkar_perut;
        $pemeriksaan->gula_darah = $request->gula_darah;
        $pemeriksaan->visus_mata = $request->visus_mata;
        $pemeriksaan->status_proses = 'dokter';

        // Mengambil ID user (perawat) yang sedang login saat ini
        $pemeriksaan->id_perawat_acc = Auth::id();
        $pemeriksaan->save();

        return redirect()->back()->with('success', 'Data pemeriksaan berhasil diperbarui.');
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
            'Disabilitas', 'Tinggi Badan', 'Berat Badan', 'IMT', 'Lingkar Perut', 'Gula Darah', 'Visus Mata',
            'Riwayat Sakit', 'Riwayat Kesehatan Fisik', 'Keluhan', 'Status Pembayaran', 'Tanggal Pengajuan'
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
                $data->lingkar_perut,
                $data->gula_darah,
                $data->visus_mata,
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
            'Disabilitas', 'Tinggi Badan', 'Berat Badan', 'IMT', 'Lingkar Perut', 'Gula Darah', 'Visus Mata',
            'Riwayat Sakit', 'Riwayat Kesehatan Fisik', 'Keluhan', 'Status Pembayaran', 'Tanggal Pengajuan'
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
                    $item->lingkar_perut,
                    $item->gula_darah,
                    $item->visus_mata,
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
}
