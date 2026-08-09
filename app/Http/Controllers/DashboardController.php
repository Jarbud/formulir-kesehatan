<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\PemeriksaanKesehatan;
use App\Models\Faculty;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'Tempat Tanggal Lahir', 'Alamat Asal', 'Alamat Malang', 'WA', 'Nama Wali', 'WA Wali', 'Skrining Kesehatan Mental', 
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
                $data->skrining_kesehatan_mental,
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
            'Tempat Tanggal Lahir', 'Alamat Asal', 'Alamat Malang', 'WA', 'Nama Wali', 'WA Wali', 'Skrining Kesehatan Mental',
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
                    $item->skrining_kesehatan_mental,
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

    public function laporanIndex(Request $request)
    {
        $faculties = Faculty::with('programStudis')->get();
        
        $query = PemeriksaanKesehatan::query();
        
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
        
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
        
        $total = $query->count();
        $sudah_export = (clone $query)->whereNotNull('exported_at')->count();
        $belum_export = (clone $query)->whereNull('exported_at')->count();
        $export_terakhir = (clone $query)->whereNotNull('exported_at')->max('exported_at');
        
        return view('admin.laporan', compact('faculties', 'total', 'sudah_export', 'belum_export', 'export_terakhir'));
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
            'Tempat Tanggal Lahir', 'Alamat Asal', 'Alamat Malang', 'WA', 'Nama Wali', 'WA Wali', 'Skrining Kesehatan Mental',
            'Disabilitas', 'Tinggi Badan', 'Berat Badan', 'IMT', 'Lingkar Perut', 'Gula Darah', 'Visus Mata',
            'Riwayat Sakit', 'Riwayat Kesehatan Fisik', 'Keluhan', 'Status Pembayaran', 'Tanggal Pengajuan', 'Status Proses', 'Kesimpulan', 'Rekomendasi'
        ];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $item) {
                $row = [
                    $item->id, $item->user_id, $item->name, $item->nik, $item->nim, $item->jenis_kelamin, $item->usia, $item->fakultas, $item->prodi, 
                    $item->tempat_tanggal_lahir, $item->alamat_asal, $item->alamat_malang, $item->wa, $item->nama_wali, $item->wa_wali, $item->skrining_kesehatan_mental,
                    $item->disabilitas, $item->tinggi_badan, $item->berat_badan, $item->imt, $item->lingkar_perut, $item->gula_darah, $item->visus_mata,
                    $item->riwayat_sakit, $item->riwayat_kesehatan_fisik, $item->keluhan, $item->status_pembayaran, $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : '',
                    $item->status_proses, $item->kesimpulan, $item->rekomendasi
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportLaporanPdf(Request $request)
    {
        $batch = in_array($request->batch, [25, 50, 75, 100]) ? $request->batch : 25;

        $query = PemeriksaanKesehatan::query();

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
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

        // Hanya ambil data yang belum diexport
        $query->whereNull('exported_at');
        $data = $query->orderBy('created_at', 'asc')->limit($batch)->get();

        if ($data->isEmpty()) {
            return redirect()->route('admin.laporan.index', $request->except(['batch', '_token']))
                ->with('info', 'Semua data sudah diexport. Klik "Reset Status Export" jika ingin mengekspor ulang.');
        }

        // Simpan ID yang akan ditandai sebagai sudah diexport
        $exportedIds = $data->pluck('id')->toArray();

        // Generate PDF
        $pdf = Pdf::loadView('admin.pdf.laporan', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        // Tandai data yang diexport
        PemeriksaanKesehatan::whereIn('id', $exportedIds)->update(['exported_at' => now()]);

        // Buat pesan flash berisi nama yang diexport (max 5 ditampilkan)
        $names = $data->map(function ($item) {
            return $item->name . ' (' . $item->nim . ')';
        });
        $display = $names->take(5)->implode(', ');
        $extra = $names->count() > 5 ? ', dan ' . ($names->count() - 5) . ' lainnya' : '';

        session()->flash('success', 'Berhasil export ' . $data->count() . ' data: ' . $display . $extra);

        return $pdf->stream('Laporan_Kesehatan_' . date('Ymd_His') . '.pdf');
    }

    public function resetExportStatus(Request $request)
    {
        $query = PemeriksaanKesehatan::query();

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
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

        $count = $query->whereNotNull('exported_at')->count();
        $query->update(['exported_at' => null]);

        return redirect()->route('admin.laporan.index', $request->except(['_token']))
            ->with('success', 'Status export berhasil direset untuk ' . $count . ' data.');
    }

    public function rangkumanPemeriksaan(Request $request)
    {
        $faculties = Faculty::with('programStudis')->get();
        
        $query = PemeriksaanKesehatan::query();
        
        // Filter Fakultas
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        
        // Filter Prodi
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
        
        // Filter Waktu
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
        
        // Filter Role
        if ($request->filled('role') && $request->role !== 'semua') {
            if ($request->role === 'perawat') {
                $query->whereNotNull('id_perawat_acc');
            } elseif ($request->role === 'dokter') {
                $query->whereNotNull('id_dokter_acc');
            } elseif ($request->role === 'admin') {
                $query->whereIn('status_proses', ['admin', 'selesai']);
            }
        }

        $total = $query->count();
        
        // Perawat Summary (terfilter)
        $perawatSummary = (clone $query)
            ->whereNotNull('id_perawat_acc')
            ->join('users', 'pemeriksaan_kesehatans.id_perawat_acc', '=', 'users.id')
            ->select('users.id', 'users.name', DB::raw('count(pemeriksaan_kesehatans.id) as total'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->get();
        
        // Dokter Summary (terfilter)
        $dokterSummary = (clone $query)
            ->whereNotNull('id_dokter_acc')
            ->join('users', 'pemeriksaan_kesehatans.id_dokter_acc', '=', 'users.id')
            ->select('users.id', 'users.name', DB::raw('count(pemeriksaan_kesehatans.id) as total'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->get();
        
        return view('admin.rangkuman', compact('faculties', 'perawatSummary', 'dokterSummary', 'total'));
    }

    public function exportRangkumanExcel(Request $request)
    {
        $query = PemeriksaanKesehatan::query();

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
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
        if ($request->filled('role') && $request->role !== 'semua') {
            if ($request->role === 'perawat') {
                $query->whereNotNull('id_perawat_acc');
            } elseif ($request->role === 'dokter') {
                $query->whereNotNull('id_dokter_acc');
            } elseif ($request->role === 'admin') {
                $query->whereIn('status_proses', ['admin', 'selesai']);
            }
        }

        $data = $query->with(['perawat', 'dokter'])->orderBy('created_at', 'desc')->get();

        $roleLabel = $request->role === 'perawat' ? 'Perawat' : ($request->role === 'dokter' ? 'Dokter' : ($request->role === 'admin' ? 'Admin' : 'Semua'));
        $filename = "Rangkuman_Kinerja_" . $roleLabel . "_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID Pemeriksaan', 'NIK', 'NIM', 'Nama Mahasiswa', 'Jenis Kelamin', 'Usia', 'Fakultas', 'Prodi',
            'Perawat Pemeriksa', 'Dokter Pemeriksa', 'Tinggi Badan', 'Berat Badan', 'IMT',
            'Tekanan Darah', 'Ishihara', 'Lingkar Perut', 'Gula Darah', 'Visus Mata',
            'Kesimpulan', 'Rekomendasi', 'Status Proses', 'Tanggal Pemeriksaan'
        ];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fwrite($file, "sep=,\n");
            fputcsv($file, $columns);

            foreach ($data as $item) {
                $row = [
                    $item->id,
                    $item->nik,
                    $item->nim,
                    $item->name,
                    $item->jenis_kelamin,
                    $item->usia,
                    $item->fakultas,
                    $item->prodi,
                    $item->perawat ? $item->perawat->name : '-',
                    $item->dokter ? $item->dokter->name : '-',
                    $item->tinggi_badan,
                    $item->berat_badan,
                    $item->imt,
                    $item->tekanan_darah,
                    $item->ishihara,
                    $item->lingkar_perut,
                    $item->gula_darah,
                    $item->visus_mata,
                    $item->kesimpulan,
                    $item->rekomendasi,
                    $item->status_proses,
                    $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : ''
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportRangkumanPdf(Request $request)
    {
        $batch = in_array($request->batch, [25, 50, 75, 100]) ? $request->batch : 25;

        $query = PemeriksaanKesehatan::query();

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
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
        if ($request->filled('role') && $request->role !== 'semua') {
            if ($request->role === 'perawat') {
                $query->whereNotNull('id_perawat_acc');
            } elseif ($request->role === 'dokter') {
                $query->whereNotNull('id_dokter_acc');
            } elseif ($request->role === 'admin') {
                $query->whereIn('status_proses', ['admin', 'selesai']);
            }
        }

        $query->whereNull('exported_at');
        $data = $query->orderBy('created_at', 'asc')->limit($batch)->get();

        if ($data->isEmpty()) {
            return redirect()->route('admin.rangkuman', $request->except(['batch', '_token']))
                ->with('info', 'Semua data sudah diexport. Klik "Reset Status Export" jika ingin mengekspor ulang.');
        }

        $exportedIds = $data->pluck('id')->toArray();

        $pdf = Pdf::loadView('admin.pdf.laporan', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        PemeriksaanKesehatan::whereIn('id', $exportedIds)->update(['exported_at' => now()]);

        $roleLabel = $request->role === 'perawat' ? 'Perawat' : ($request->role === 'dokter' ? 'Dokter' : ($request->role === 'admin' ? 'Admin' : 'Semua'));

        $names = $data->map(function ($item) {
            return $item->name . ' (' . $item->nim . ')';
        });
        $display = $names->take(5)->implode(', ');
        $extra = $names->count() > 5 ? ', dan ' . ($names->count() - 5) . ' lainnya' : '';

        session()->flash('success', 'Berhasil export ' . $data->count() . ' data (' . $roleLabel . '): ' . $display . $extra);

        return $pdf->download('Rangkuman_Kinerja_' . $roleLabel . '_' . date('Ymd_His') . '.pdf');
    }

    public function exportKinerjaDetails($role, $id)
    {
        $user = User::findOrFail($id);
        
        if ($role === 'perawat') {
            $pemeriksaans = PemeriksaanKesehatan::where('id_perawat_acc', $id)->orderBy('created_at', 'desc')->get();
            $titleRole = "Perawat";
        } elseif ($role === 'dokter') {
            $pemeriksaans = PemeriksaanKesehatan::where('id_dokter_acc', $id)->orderBy('created_at', 'desc')->get();
            $titleRole = "Dokter";
        } else {
            abort(404);
        }

        $nameParts = explode(' ', trim($user->name));
        $shortName = implode('_', array_slice($nameParts, 0, 2));
        $cleanName = preg_replace('/[^A-Za-z0-9_]/', '', $shortName);

        $filename = "Kinerja_" . $titleRole . "_" . $cleanName . "_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID Pemeriksaan', 'NIK', 'NIM', 'Nama Mahasiswa', 'Jenis Kelamin', 'Usia', 'Fakultas', 'Prodi', 
            'Tinggi Badan', 'Berat Badan', 'IMT', 'Tekanan Darah', 'Ishihara', 'Lingkar Perut', 'Gula Darah', 'Visus Mata',
            'Kesimpulan', 'Rekomendasi', 'Tanggal Pemeriksaan'
        ];

        $callback = function() use($pemeriksaans, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tambahkan BOM agar karakter khusus terbaca Excel dengan baik
            fwrite($file, "\xEF\xBB\xBF");
            // Tambahkan sep=, agar Excel langsung membagi kolom dengan koma tanpa terpengaruh regional setting
            fwrite($file, "sep=,\n");
            
            fputcsv($file, $columns);

            foreach ($pemeriksaans as $item) {
                $row = [
                    $item->id,
                    $item->nik,
                    $item->nim,
                    $item->name,
                    $item->jenis_kelamin,
                    $item->usia,
                    $item->fakultas,
                    $item->prodi,
                    $item->tinggi_badan,
                    $item->berat_badan,
                    $item->imt,
                    $item->tekanan_darah,
                    $item->ishihara,
                    $item->lingkar_perut,
                    $item->gula_darah,
                    $item->visus_mata,
                    $item->kesimpulan,
                    $item->rekomendasi,
                    $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : ''
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportKinerjaAll()
    {
        $pemeriksaans = PemeriksaanKesehatan::with(['perawat', 'dokter'])
            ->where(function($query) {
                $query->whereNotNull('id_perawat_acc')
                      ->orWhereNotNull('id_dokter_acc');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = "Semua_Kinerja_Pemeriksaan_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => 'attachment; filename="' . $filename . '"',
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID Pemeriksaan', 'NIK', 'NIM', 'Nama Mahasiswa', 'Jenis Kelamin', 'Usia', 'Fakultas', 'Prodi', 
            'Perawat Pemeriksa', 'Dokter Pemeriksa', 'Tinggi Badan', 'Berat Badan', 'IMT', 
            'Tekanan Darah', 'Ishihara', 'Lingkar Perut', 'Gula Darah', 'Visus Mata',
            'Kesimpulan', 'Rekomendasi', 'Tanggal Pemeriksaan'
        ];

        $callback = function() use($pemeriksaans, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tambahkan BOM agar karakter khusus terbaca Excel dengan baik
            fwrite($file, "\xEF\xBB\xBF");
            // Tambahkan sep=, agar Excel langsung membagi kolom dengan koma tanpa terpengaruh regional setting
            fwrite($file, "sep=,\n");
            
            fputcsv($file, $columns);

            foreach ($pemeriksaans as $item) {
                $row = [
                    $item->id,
                    $item->nik,
                    $item->nim,
                    $item->name,
                    $item->jenis_kelamin,
                    $item->usia,
                    $item->fakultas,
                    $item->prodi,
                    $item->perawat ? $item->perawat->name : '-',
                    $item->dokter ? $item->dokter->name : '-',
                    $item->tinggi_badan,
                    $item->berat_badan,
                    $item->imt,
                    $item->tekanan_darah,
                    $item->ishihara,
                    $item->lingkar_perut,
                    $item->gula_darah,
                    $item->visus_mata,
                    $item->kesimpulan,
                    $item->rekomendasi,
                    $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : ''
                ];
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string',
            'nik' => 'nullable|string',
            'nim' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'usia' => 'nullable|integer',
            'fakultas' => 'nullable|string',
            'prodi' => 'nullable|string',
            'tempat_tanggal_lahir' => 'nullable|string',
            'alamat_asal' => 'nullable|string',
            'alamat_malang' => 'nullable|string',
            'wa' => 'nullable|string',
            'nama_wali' => 'nullable|string',
            'wa_wali' => 'nullable|string',
            'skrining_kesehatan_mental' => 'nullable|string',
            'disabilitas' => 'nullable|string',
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'imt' => 'nullable|numeric',
            'riwayat_sakit' => 'nullable|string',
            'riwayat_kesehatan_fisik' => 'nullable|string',
            'keluhan' => 'nullable|string',
            'tekanan_darah' => 'nullable|string',
            'ishihara' => 'nullable|string',
            'lingkar_perut' => 'nullable|numeric',
            'gula_darah' => 'nullable|numeric',
            'visus_mata' => 'nullable|in:Normal,Gangguan',
            'kesimpulan' => 'nullable|string',
            'rekomendasi' => 'nullable|string',
        ]);

        $pemeriksaan = PemeriksaanKesehatan::findOrFail($id);
        $pemeriksaan->update([
            'name' => $request->name,
            'nik' => $request->nik,
            'nim' => $request->nim,
            'jenis_kelamin' => $request->jenis_kelamin,
            'usia' => $request->usia,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
            'alamat_asal' => $request->alamat_asal,
            'alamat_malang' => $request->alamat_malang,
            'wa' => $request->wa,
            'nama_wali' => $request->nama_wali,
            'wa_wali' => $request->wa_wali,
            'skrining_kesehatan_mental' => $request->skrining_kesehatan_mental,
            'disabilitas' => $request->disabilitas,
            'tinggi_badan' => $request->tinggi_badan,
            'berat_badan' => $request->berat_badan,
            'imt' => $request->imt,
            'riwayat_sakit' => $request->riwayat_sakit,
            'riwayat_kesehatan_fisik' => $request->riwayat_kesehatan_fisik,
            'keluhan' => $request->keluhan,
            'tekanan_darah' => $request->tekanan_darah,
            'ishihara' => $request->ishihara,
            'lingkar_perut' => $request->lingkar_perut,
            'gula_darah' => $request->gula_darah,
            'visus_mata' => $request->visus_mata,
            'kesimpulan' => $request->kesimpulan,
            'rekomendasi' => $request->rekomendasi,
        ]);

        return back()->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

}

