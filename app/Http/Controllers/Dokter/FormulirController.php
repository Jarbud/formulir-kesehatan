<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemeriksaanKesehatan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Faculty;


class FormulirController extends Controller
{
    //
    public function cetakPdf($id)
    {
        // 1. Ambil data dari database (contoh menggunakan data dummy agar sesuai gambar)
        $data = PemeriksaanKesehatan::findOrFail($id); 
        

        // 2. Load view blade dan passing data
        $pdf = Pdf::loadView('dokter.pdf.formulir_kesehatan', compact('data'));

        // Set ukuran kertas (A4, portrait)
        $pdf->setPaper('A4', 'portrait');

        // 3. Return stream (untuk melihat di browser) atau download (langsung unduh)
        // return $pdf->download('Formulir_Kesehatan_'.$data['nim'].'.pdf'); 
        return $pdf->stream('Formulir_Kesehatan_'.$data['nim'].'.pdf'); 
    }
}
