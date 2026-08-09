<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\PemeriksaanKesehatan;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportLaporanFakultas extends Command
{
    protected $signature = 'export:laporan-fakultas {--force}';
    protected $description = 'Export PDF laporan kesehatan per fakultas dan kesimpulan';

    private $kesimpulanMap = [
        'Layak'                        => 'Layak',
        'Layak dengan Syarat'          => 'Layak_Bersyarat',
        'Tidak Layak Mengikuti PKKMB'  => 'Tidak_Layak',
    ];

    public function handle()
    {
        ini_set('memory_limit', '2G');
        $force = $this->option('force');

        $year = date('Y');
        $storagePath = storage_path('app');
        $chunkSize = 50;

        $fakultasList = PemeriksaanKesehatan::distinct()->pluck('fakultas')->filter()->sort()->values();

        if ($fakultasList->isEmpty()) {
            $this->error('Tidak ada data fakultas ditemukan.');
            return 1;
        }

        $this->info("Ditemukan {$fakultasList->count()} fakultas. Memulai export (chunk {$chunkSize} data)...\n");

        $totalGenerated = 0;
        $totalSkipped = 0;

        foreach ($fakultasList as $fakultas) {
            $abbr = $this->extractAbbr($fakultas);

            foreach ($this->kesimpulanMap as $kesimpulanFull => $kesimpulanFile) {
                $totalCount = PemeriksaanKesehatan::where('fakultas', $fakultas)
                    ->where('kesimpulan', $kesimpulanFull)
                    ->count();

                if ($totalCount === 0) {
                    $totalSkipped++;
                    continue;
                }

                $totalChunks = ceil($totalCount / $chunkSize);
                $chunkIndex = 0;

                PemeriksaanKesehatan::where('fakultas', $fakultas)
                    ->where('kesimpulan', $kesimpulanFull)
                    ->orderBy('created_at', 'asc')
                    ->chunk($chunkSize, function ($data) use (&$chunkIndex, $totalChunks, $abbr, $kesimpulanFull, $kesimpulanFile, $year, $storagePath, $fakultas, &$totalGenerated, $force) {
                        $chunkIndex++;

                        if ($totalChunks === 1) {
                            $filename = "Laporan_{$kesimpulanFile}_{$abbr}_{$year}.pdf";
                        } else {
                            $filename = "Laporan_{$kesimpulanFile}_{$abbr}_{$year}_Part{$chunkIndex}.pdf";
                        }

                        $filepath = $storagePath . DIRECTORY_SEPARATOR . $filename;

                        if (!$force && file_exists($filepath)) {
                            $this->line("  <comment>⏭</comment> {$fakultas} | {$kesimpulanFull} | Part {$chunkIndex}/{$totalChunks} | SKIP (sudah ada)");
                            return;
                        }

                        $pdf = Pdf::loadView('admin.pdf.laporan', ['data' => $data]);
                        $pdf->setPaper('A4', 'portrait');
                        $pdf->save($filepath);

                        $totalGenerated++;
                        $this->line("  <info>✓</info> {$fakultas} | {$kesimpulanFull} | Part {$chunkIndex}/{$totalChunks} | {$data->count()} data → {$filename}");

                        unset($data, $pdf);
                        gc_collect_cycles();
                    });
            }
        }

        $this->newLine();
        $this->info("Selesai! {$totalGenerated} PDF berhasil dibuat, {$totalSkipped} dilewati (0 data).");
        $this->line("Lokasi: {$storagePath}");

        return 0;
    }

    private function extractAbbr($fakultas)
    {
        if (preg_match('/\(([^)]+)\)\s*$/', $fakultas, $matches)) {
            return $matches[1];
        }

        $words = explode(' ', $fakultas);
        $abbr = '';
        foreach ($words as $word) {
            if ($word === ucfirst(strtolower($word)) && strlen($word) > 2) {
                $abbr .= $word[0];
            }
        }

        return strtoupper($abbr) ?: strtoupper(substr(md5($fakultas), 0, 3));
    }
}
