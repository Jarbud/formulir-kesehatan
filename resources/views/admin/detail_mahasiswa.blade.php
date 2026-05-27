<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Mahasiswa: ') }} {{ $mahasiswa->name }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 shadow-sm text-gray-700 text-sm font-bold rounded-md transition">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Informasi Singkat Mahasiswa -->
            <div class="bg-white shadow-sm border border-gray-100 sm:rounded-xl p-6 mb-6">
                <h3 class="text-lg font-bold mb-4 text-gray-900 border-b pb-2">Informasi Akun</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                    <div>
                        <span class="text-gray-500 block uppercase text-xs font-bold tracking-wider">Nama Lengkap</span>
                        <span class="font-semibold text-gray-900 text-base mt-1 block">{{ $mahasiswa->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block uppercase text-xs font-bold tracking-wider">Email Terdaftar</span>
                        <span class="font-semibold text-gray-900 text-base mt-1 block">{{ $mahasiswa->email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block uppercase text-xs font-bold tracking-wider">Tanggal Registrasi</span>
                        <span class="font-semibold text-gray-900 text-base mt-1 block">{{ $mahasiswa->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat Formulir -->
            <div class="bg-white shadow-sm border border-gray-100 sm:rounded-xl p-6">
                <h3 class="text-lg font-bold mb-6 text-gray-900">Riwayat Pengajuan Formulir</h3>
                
                @if($riwayats->isEmpty())
                    <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        Mahasiswa ini belum pernah mengajukan formulir pemeriksaan kesehatan.
                    </div>
                @else
                    <div class="w-full overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table id="riwayatTable" class="w-full text-left border-collapse min-w-[1000px]"> {{-- Berikan minimal lebar statis agar tidak penyok --}}
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-4 w-[15%]">Tanggal</th>
                                    <th class="px-6 py-4 w-[12%]">NIM</th>
                                    <th class="px-6 py-4 w-[15%]">Bukti Pembayaran</th>
                                    <th class="px-6 py-4 w-[13%]">Status Proses</th>
                                    <th class="px-6 py-4 w-[20%]">Tenaga Kesehatan</th> {{-- Dipersingkat judulnya agar tidak memakan space --}}
                                    <th class="px-6 py-4 w-[15%]">Dokter</th>
                                    <th class="px-6 py-4 text-center w-[10%]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($riwayats as $riwayat)
                                    <tr class="hover:bg-gray-50/70 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                                            {{ $riwayat->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                            {{ $riwayat->nim }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                            @if($riwayat->bukti_pembayaran)
                                                <a href="{{ asset('storage/' . $riwayat->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline inline-flex items-center gap-1">
                                                    Lihat File Bukti
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 uppercase tracking-wide font-semibold text-xs">
                                            {{ $riwayat->status_proses }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 font-medium max-w-[200px] truncate" title="{{ $riwayat->id_perawat_acc ? $riwayat->perawat->name : '' }}">
                                            @if($riwayat->id_perawat_acc)
                                                {{ $riwayat->perawat->name }}
                                            @else
                                                <span class="text-gray-400 italic font-normal">Belum Diperiksa</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 font-medium max-w-[150px] truncate" title="{{ $riwayat->id_dokter_acc ? $riwayat->dokter->name : '' }}">
                                            @if($riwayat->id_dokter_acc)
                                                {{ $riwayat->dokter->name }}
                                            @else
                                                <span class="text-gray-400 italic font-normal">Belum Diperiksa</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{-- Menggunakan flex row agar tombol berjejer rapi ke samping, bukan numpuk vertikal --}}
                                            <div class="flex flex-col items-center justify-center gap-2 whitespace-nowrap">
                                                <a href="{{ route('admin.cetak.formulir', $riwayat->id) }}" 
                                                target="_blank" 
                                                class="w-full justify-center inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 rounded-md text-xs font-bold transition">
                                                    Lihat PDF
                                                </a>
                                                <a href="{{ secure_url(route('admin.export.excel', $riwayat->id)) }}" 
                                                class="w-full justify-center inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 rounded-md text-xs font-bold transition">
                                                    Export Excel
                                                </a>
                                                @if($riwayat->status_proses == 'admin')
                                                <button type="button" onclick="openModal('modal-ttd-{{ $riwayat->id }}')" 
                                                class="w-full justify-center inline-flex items-center px-3 py-1.5 bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200 rounded-md text-xs font-bold transition">
                                                    TTD
                                                </button>
                                                @endif
                                            </div>
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Kumpulan Modal TTD -->
                    @foreach($riwayats as $riwayat)
                        @if($riwayat->status_proses !== 'selesai')
                        <div id="modal-ttd-{{ $riwayat->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeModal('modal-ttd-{{ $riwayat->id }}')"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <form action="{{ route('admin.pemeriksaan.ttd', $riwayat->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Konfirmasi Tanda Tangan</h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menandatangani dan menyelesaikan dokumen pemeriksaan ini?</p>
                                            </div>
                                        </div>
                                        <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">Iya, Tandatangani</button>
                                            <button type="button" onclick="closeModal('modal-ttd-{{ $riwayat->id }}')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Tidak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <!-- CSS & JS untuk fitur Search, Sort, dan Filter (Simple DataTables) -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
        <style>
            /* Custom CSS untuk merapikan Simple DataTables dengan Tailwind */
            .dataTable-input, .dataTable-selector {
                border: 1px solid #e5e7eb !important;
                border-radius: 0.375rem !important;
                padding: 0.375rem 0.75rem !important;
                font-size: 0.875rem !important;
                outline: none !important;
            }
            .datatable-selector {
                width: 75px !important;
                padding-right: 1.75rem !important; /* Ruang khusus agar angka tidak menabrak panah */
            }
            .dataTable-input:focus, .dataTable-selector:focus {
                border-color: #3b82f6 !important;
                box-shadow: 0 0 0 1px #3b82f6 !important;
            }
            .dataTable-pagination a {
                border-radius: 0.375rem !important;
            }
            .dataTable-pagination .active a, .dataTable-pagination .active a:hover {
                background-color: #3b82f6 !important;
                color: white !important;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                if (document.getElementById("riwayatTable") && typeof simpleDatatables.DataTable !== 'undefined') {
                    new simpleDatatables.DataTable("#riwayatTable", {
                        searchable: true,
                        sortable: true,
                        perPage: 5,
                        labels: {
                            placeholder: "Cari riwayat...",
                            perPage: "data per halaman",
                            noRows: "Tidak ada riwayat yang ditemukan",
                            info: "Menampilkan {start} sampai {end} dari {rows} data",
                        }
                    });
                }
            });
        </script>
        <script>
            function openModal(id) {
                document.getElementById(id).classList.remove('hidden');
            }

            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
            }
        </script>
    </div>
</x-app-layout>
