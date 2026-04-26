<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemeriksaanKesehatan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class FormulirController extends Controller
{
    //
    public function index()
    {
        
        return view('mahasiswa.formulir');
    }

    public function simpan(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tinggi_badan' => 'required|numeric',
            'berat_badan'  => 'required|numeric',
            'imt'          => 'required|numeric',
            // Tambahkan validasi lain jika perlu
        ]);

        try {
            // 2. Simpan ke Database
            $pemeriksaan = PemeriksaanKesehatan::create([
                'user_id'               => Auth::id(), // Mengambil ID user yang login
                'name'                  => $request->name,
                'nik'                   => $request->nik,
                'nim'                   => $request->nim,
                'jenis_kelamin'         => $request->jenis_kelamin,
                'usia'                  => $request->usia,
                'fakultas'              => $request->fakultas,
                'prodi'                 => $request->prodi,
                'tempat_tanggal_lahir'  => $request->tempat_tanggal_lahir,
                'disabilitas'           => $request->disabilitas,
                'tinggi_badan'          => $request->tinggi_badan,
                'berat_badan'           => $request->berat_badan,
                'imt'                   => $request->imt,
                'riwayat_sakit'         => $request->riwayat_sakit,
                'keluhan'               => $request->keluhan,
            ]);

            // 3. Redirect ke halaman pembayaran (sesuai teks tombol 'Simpan & Bayar')
            // Misalnya Anda menggunakan Midtrans atau payment gateway lainnya
            return view('mahasiswa.bayar', compact('pemeriksaan'))
            ->with('success', 'Data berhasil disimpan. Silahkan lanjut ke pembayaran.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
        
    }

    public function uploadBukti(Request $request)
    {
        $request->validate([
            'pemeriksaan_id'   => 'required|exists:pemeriksaan_kesehatans,id',
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
        // 1. Ambil data dari database (contoh menggunakan data dummy agar sesuai gambar)
        $data = PemeriksaanKesehatan::findOrFail($id); 
        
        // $data = [
        //     'jadwal' => '6 Agustus 2025',
        //     'nama' => 'Abednego Yekti Bekti',
        //     'jk' => 'Laki-laki',
        //     'nim' => '250611600312',
        //     'ttl' => 'Tulungagung, 12-10-2006',
        //     'usia' => 18,
        //     'fakultas' => 'FIK/ Pendidikan Jasmani, Kesehatan dan Rekreasi',
        //     'disabilitas' => 'Tidak ada',
        //     'tb' => '173',
        //     'bb' => '78',
        //     'imt' => '26.1',
        //     'status_imt' => 'Overweight',
        //     'tensi' => '141/70',
        //     'ishihara' => '(-)',
        //     'riwayat_sakit' => 'Maag',
        //     'keluhan' => 'Tidak ada',
        //     'kesimpulan' => 'Layak',
        // ];

        // 2. Load view blade dan passing data
        $pdf = Pdf::loadView('mahasiswa.pdf.formulir_kesehatan', compact('data'));

        // Set ukuran kertas (A4, portrait)
        $pdf->setPaper('A4', 'portrait');

        // 3. Return stream (untuk melihat di browser) atau download (langsung unduh)
        // return $pdf->download('Formulir_Kesehatan_'.$data['nim'].'.pdf'); 
        return $pdf->stream('Formulir_Kesehatan_'.$data['nim'].'.pdf'); 
    }
}
