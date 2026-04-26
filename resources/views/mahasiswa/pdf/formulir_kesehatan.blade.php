<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pemeriksaan Kesehatan</title>
    <style>
        /* Mengatur margin kertas agar lebih lebar areanya (Atas-Bawah 1cm, Kiri-Kanan 1.5cm) */
        @page {
            margin: 1cm 1.5cm; 
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt; /* Sedikit diturunkan agar lebih aman */
            line-height: 1.15; /* Merapatkan spasi antar baris */
            margin: 0;
            padding: 0;
        }

        /* Styling Header */
        .header-table {
            width: 100%;
            border-bottom: 2px solid black;
            padding-bottom: 3px;
            margin-bottom: 10px;
        }
        .header-text {
            text-align: center;
        }
        .header-text h3 { margin: 0; padding: 0; font-size: 13pt; }
        .header-text h4 { margin: 0; padding: 0; font-size: 11pt; }
        .header-text p { margin: 2px 0 0 0; font-size: 8.5pt; }

        /* Typography & Utility */
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .mt-1 { margin-top: 5px; }
        .mt-2 { margin-top: 10px; }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        
        /* Form Table */
        .form-table { width: 100%; margin-top: 10px; border-collapse: collapse; }
        .form-table td { vertical-align: top; padding: 2px 0; }
        .col-label { width: 25%; }
        .col-titik { width: 3%; text-align: center; }
        .col-value { width: 72%; }

        /* Footer / Tanda Tangan */
        .ttd-table {
            width: 100%;
            margin-top: 20px;
        }
        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }
        
        /* Memberikan ruang untuk tanda tangan tanpa menggunakan <br> */
        .ruang-ttd {
            height: 65px; 
        }

        .garis-bawah {
            border-bottom: 1px solid black;
            display: inline-block;
            width: 90%;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>

    @php
        $imt = $data->imt ?? 0;
        $status_imt = '-';
        if ($imt < 18.5) $status_imt = 'Underweight';
        elseif ($imt >= 18.5 && $imt <= 24.9) $status_imt = 'Normal';
        elseif ($imt >= 25 && $imt <= 29.9) $status_imt = 'Overweight';
        elseif ($imt >= 30) $status_imt = 'Obesity';
    @endphp

    <table class="header-table">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ public_path('images/logo-um.jpg') }}" width="70" alt="Logo UM">
            </td>
            <td width="70%" class="header-text">
                <h4 class="font-bold">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN,<br>RISET DAN TEKNOLOGI</h4>
                <h3 class="font-bold">UNIVERSITAS NEGERI MALANG</h3>
                <h4 class="font-bold">UPT LAYANAN KESEHATAN</h4>
                <h3 class="font-bold">KLINIK PRATAMA</h3>
                <p>Jalan Semarang 5, Malang 65145<br>
                Telepon: 0341 - 551312. Faksimile: 0341-559211<br>
                Laman: www.um.ac.id</p>
            </td>
            <td width="15%" class="text-center">
                <img src="{{ public_path('images/logo-kecil.png') }}" width="70" alt="Logo Klinik">
            </td>
        </tr>
    </table>

    <div class="font-bold mb-1 mt-1">Jadwal Pemeriksaan: </div>

    <div class="text-center mt-2 mb-2">
        <h4 style="margin:0;">FORMULIR PEMERIKSAAN KESEHATAN MAHASISWA BARU</h4>
        <h4 style="margin:0;">UNIVERSITAS NEGERI MALANG {{ date('Y') }}</h4>
    </div>

    <p style="margin-bottom: 5px;">Dokter Klinik Pratama Universitas Negeri Malang menerangkan bahwa:</p>

    <table class="form-table">
        <tr>
            <td class="col-label">Nama</td><td class="col-titik">:</td>
            <td class="col-value">{{ $data->name }}</td>
        </tr>
        <tr>
            <td class="col-label">Jenis Kelamin</td><td class="col-titik">:</td>
            <td class="col-value">{{ ucfirst($data->jenis_kelamin) }}</td>
        </tr>
        <tr>
            <td class="col-label">NIM</td><td class="col-titik">:</td>
            <td class="col-value">{{ $data->nim }}</td>
        </tr>
        <tr>
            <td class="col-label">Tempat, Tanggal Lahir</td><td class="col-titik">:</td>
            <td class="col-value">
                <table width="100%" style="margin:0; padding:0; border:none; border-collapse: collapse;">
                    <tr>
                        <td width="70%" style="padding:0;">{{ $data->tempat_tanggal_lahir }}</td>
                        <td width="30%" style="padding:0;">Usia: {{ $data->usia }} Tahun</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="col-label">Fakultas/ Prodi</td><td class="col-titik">:</td>
            <td class="col-value">{{ $data->fakultas }} / {{ $data->prodi }}</td>
        </tr>
        <tr>
            <td class="col-label">Disabilitas</td><td class="col-titik">:</td>
            <td class="col-value">{{ $data->disabilitas }}</td>
        </tr>
    </table>

    <div style="height: 10px;"></div>

    <table class="form-table" style="margin-top: 0;">
        <tr>
            <td class="col-label">Tinggi Badan</td><td class="col-titik">:</td>
            <td class="col-value">{{ $data->tinggi_badan }} cm</td>
        </tr>
        <tr>
            <td class="col-label">Berat Badan</td><td class="col-titik">:</td>
            <td class="col-value">{{ $data->berat_badan }} kg</td>
        </tr>
        <tr>
            <td class="col-label">IMT*</td><td class="col-titik">:</td>
            <td class="col-value">
                <u>&nbsp;&nbsp;{{ $data->imt }}&nbsp;&nbsp;</u> kg/m² 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <strong>Status*</strong> : <u>&nbsp;&nbsp;{{ $status_imt }}&nbsp;&nbsp;</u>
            </td>
        </tr>
        <tr>
            <td class="col-label">Tekanan Darah*</td><td class="col-titik">:</td>
            <td class="col-value"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> mmHg</td>
        </tr>
        <tr>
            <td class="col-label">Ishihara Test*</td><td class="col-titik">:</td>
            <td class="col-value">
                <strong>( - )</strong> / ( + ) / Parsial
            </td>
        </tr>
        <tr>
            <td class="col-label">Riwayat Sakit</td><td class="col-titik">:</td>
            <td class="col-value">{{ $data->riwayat_sakit ?: '-' }}</td>
        </tr>
        
        <tr><td colspan="3"><div style="height: 10px;"></div></td></tr>
        
        <tr>
            <td class="col-label">Keluhan Saat Ini</td><td class="col-titik">:</td>
            <td class="col-value">{{ $data->keluhan ?: '-' }}</td>
        </tr>
    </table>

    <div style="height: 15px;"></div>

    <div>
        <strong><u>KESIMPULAN*</u></strong><br>
        Layak/ Layak Dengan Syarat/ Tidak Layak Mengikuti PKKMB<br>
        <em style="font-size: 9.5pt;">(coret yang tidak perlu)</em>
    </div>

    <div class="mt-2">
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td width="18%" style="vertical-align: top;"><strong><u>REKOMENDASI</u> :</strong></td>
                <td width="82%">
                    <p style="margin: 0 0 5px 0;">* <span class="garis-bawah"></span></p>
                    <p style="margin: 0;">&nbsp; <span class="garis-bawah"></span></p>
                </td>
            </tr>
        </table>
    </div>

    <table class="ttd-table">
        <tr>
            <td style="text-align: left; padding-left: 20px;">
                Malang, ..............................<br>
                Dokter Penanggungjawab
                <div class="ruang-ttd"></div>
                <strong><u>dr. Ifa mufida, MMRS</u></strong><br>
                SIP. 440.1/0928/35.73.406/2023
            </td>
            <td style="text-align: right; padding-right: 50px;">
                <br>
                Dokter Pemeriksa
                <div class="ruang-ttd"></div>
                ( .................................................. )
            </td>
        </tr>
    </table>

    <div style="font-style: italic; font-size: 9pt; margin-top: 15px;">
        Isian yang bertanda * diisi oleh petugas
    </div>

</body>
</html>