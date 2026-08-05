<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemeriksaanKesehatan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Faculty;

class FormulirController extends Controller
{
    //
    public function index()
    {
        
        // Mengambil semua fakultas beserta program studinya dari database
        $faculties = Faculty::with('programStudis')->get();
        
        // Mengirimkan data $faculties ke dalam view
        return view('mahasiswa.formulir', compact('faculties'));
    }

    public function simpan(Request $request)
    {
        $namaFakultas = $request->fakultas_nama;
        // 1. Validasi Input
        $request->validate([
            'tinggi_badan' => 'required|numeric|min:100|max:250',
            'berat_badan'  => 'required|numeric|min:20|max:300',
            'imt'          => 'required|numeric',
            'alamat_asal'  => 'required|string',
            'alamat_malang'=> 'required|string',
            'wa'           => 'required|string',
            'nama_wali'    => 'required|string',
            'wa_wali'      => 'required|string',
            // Tambahkan validasi lain jika perlu
        ]);

        // Memproses inputan riwayat kesehatan fisik dari checkbox menjadi string
        $riwayatKesehatanArr = [];
        if ($request->riwayat_kesehatan_fisik === 'Tidak ada') {
            $riwayatKesehatanArr[] = 'Tidak ada';
        } else {
            if ($request->has('riwayat_kesehatan') && is_array($request->riwayat_kesehatan)) {
                $riwayatKesehatanArr = $request->riwayat_kesehatan;
            }
            if ($request->has('riwayat_kesehatan_other') && !empty($request->riwayat_kesehatan_other)) {
                $riwayatKesehatanArr[] = $request->riwayat_kesehatan_other;
            }
        }
        $riwayatKesehatanFisik = empty($riwayatKesehatanArr) ? null : implode(', ', $riwayatKesehatanArr);

        try {
            // 2. Simpan ke Database
            $pemeriksaan = PemeriksaanKesehatan::create([
                'user_id'               => Auth::id(), // Mengambil ID user yang login
                'name'                  => $request->name,
                'nik'                   => $request->nik,
                'nim'                   => $request->nim,
                'jenis_kelamin'         => $request->jenis_kelamin,
                'usia'                  => $request->usia,
                'fakultas'              => $namaFakultas,
                'prodi'                 => $request->prodi,
                'tempat_tanggal_lahir'  => $request->tempat_tanggal_lahir,
                'alamat_asal'           => $request->alamat_asal,
                'alamat_malang'         => $request->alamat_malang,
                'wa'                    => $request->wa,
                'nama_wali'             => $request->nama_wali,
                'wa_wali'               => $request->wa_wali,
                'disabilitas'           => $request->disabilitas,
                'skrining_kesehatan_mental' => $request->skrining_kesehatan_mental,
                'tinggi_badan'          => $request->tinggi_badan,
                'berat_badan'           => $request->berat_badan,
                'imt'                   => $request->imt,
                'riwayat_sakit'         => $request->riwayat_sakit,
                'riwayat_kesehatan_fisik' => $riwayatKesehatanFisik,
                'keluhan'               => $request->keluhan,
                'status_proses'         => 'perawat',
            ]);

            return redirect()->route('bayar', $pemeriksaan->id)
            ->with('success', 'Data berhasil disimpan. Silahkan lanjut ke pembayaran.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        
    }

    public function bayar($id)
    {
        $pemeriksaan = PemeriksaanKesehatan::findOrFail($id);
        return view('mahasiswa.bayar', compact('pemeriksaan'));
    }

    public function uploadBukti(Request $request)
    {
        $request->validate([
            'pemeriksaan_id'   => 'required|integer',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pemeriksaan = PemeriksaanKesehatan::findOrFail($request->pemeriksaan_id);

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            $pemeriksaan->update([
                'bukti_pembayaran'  => $path,
                'status_pembayaran' => 'menunggu_verifikasi',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Bukti pembayaran berhasil diunggah. Silakan klik tombol "Lihat Riwayat" untuk mendowload dokumen.');
    }

    public function riwayat()
    {
        $riwayats = PemeriksaanKesehatan::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('mahasiswa.riwayat', compact('riwayats'));
    }

    public function cetakPdf($id)
    {
        // 1. Ambil data dari database
        $data = PemeriksaanKesehatan::findOrFail($id); 
        
        // Ubah string status menjadi huruf kecil semua untuk menghindari typo seperti 'Perawat' atau 'PERAWAT'
        $status = strtolower($data->status_proses);

        // 2. Tentukan view berdasarkan status
        if ($status === 'dokter') {
            $viewPath = 'perawat.pdf.formulir_kesehatan';
        } 
        elseif ($status === 'admin') {
            $viewPath = 'dokter.pdf.formulir_kesehatan';
        } 
        elseif ($status === 'selesai') {
            $viewPath = 'selesai.pdf.formulir_kesehatan';
        } 
        else {
            // JIKA STATUS TIDAK DIKENALI (misal null atau 'admin'), arahkan ke view default ini
            $viewPath = 'perawat.pdf.formulir_kesehatan';
        }

        // Eksekusi loadView di luar IF agar variabel $pdf DIJAMIN selalu terbuat dan tidak null
        $pdf = Pdf::loadView($viewPath, compact('data'));

        // Set ukuran kertas (Sekarang baris ini dijamin aman dari error member function on null)
        $pdf->setPaper('A4', 'portrait');

        // 3. Return stream
        return $pdf->stream('Formulir_Kesehatan_'.$data['nim'].'.pdf'); 
    }
}

