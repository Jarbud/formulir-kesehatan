<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Mahasiswa: ') }} {{ $mahasiswa->name }}
            </h2>
            <a href="{{ route('perawat.dashboard') }}" class="px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 shadow-sm text-gray-700 text-sm font-bold rounded-md transition">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="fadeIn" class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="font-semibold">{{ session('success') }}</span>
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
                    <div class="overflow-x-auto">
                        <table id="riwayatTable" class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-4">Tanggal</th>
                                    <th class="px-6 py-4">NIM</th>
                                    <!-- <th class="px-6 py-4">Status Pembayaran</th> -->
                                    <th class="px-6 py-4">Bukti Pembayaran</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($riwayats as $riwayat)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                            {{ $riwayat->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $riwayat->nim }}
                                        </td>
                                        <!-- <td class="px-6 py-4">
                                            @if($riwayat->status_pembayaran == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Belum Bayar</span>
                                            @elseif($riwayat->status_pembayaran == 'menunggu_verifikasi')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                                            @elseif($riwayat->status_pembayaran == 'lunas')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Lunas</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($riwayat->status_pembayaran) }}</span>
                                            @endif
                                        </td> -->
                                        <td class="px-6 py-4 text-sm font-medium">
                                            @if($riwayat->bukti_pembayaran)
                                                <a href="{{ asset('storage/' . $riwayat->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                    Lihat File Bukti
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex flex-col items-center gap-2">
                                                <a href="{{ route('perawat.cetak.formulir', $riwayat->id) }}" target="_blank" class="w-full justify-center inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 rounded-md text-xs font-bold transition">
                                                    Lihat PDF Formulir
                                                </a>
                                                
                                                <button type="button" onclick="openModal('modal-{{ $riwayat->id }}')" class="w-full justify-center inline-flex items-center px-3 py-1.5 bg-yellow-50 text-yellow-700 hover:bg-yellow-100 border border-yellow-200 rounded-md text-xs font-bold transition">
                                                    Input Pemeriksaan
                                                </button>
                                            </div>
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Kumpulan Modal Input Pemeriksaan -->
                    @foreach($riwayats as $riwayat)
                    <div id="modal-{{ $riwayat->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeModal('modal-{{ $riwayat->id }}')"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <form action="{{ route('perawat.pemeriksaan.update', $riwayat->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Input Data Pemeriksaan</h3>
                                        
                                        <div class="mt-4">
                                            <label for="tekanan_darah_{{ $riwayat->id }}" class="block text-sm font-medium text-gray-700">Tekanan Darah (mmHg)</label>
                                            <input type="text" name="tekanan_darah" id="tekanan_darah_{{ $riwayat->id }}" value="{{ $riwayat->tensi ?? '' }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        </div>

                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700">Ishihara Test</label>
                                            <div class="mt-2 space-x-4 flex">
                                                <label class="inline-flex items-center"><input type="radio" name="ishihara" value="+" {{ ($riwayat->ishihara ?? '') == '+' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required><span class="ml-2">+</span></label>
                                                <label class="inline-flex items-center"><input type="radio" name="ishihara" value="-" {{ ($riwayat->ishihara ?? '') == '-' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required><span class="ml-2">-</span></label>
                                                <label class="inline-flex items-center"><input type="radio" name="ishihara" value="parsial" {{ ($riwayat->ishihara ?? '') == 'parsial' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required><span class="ml-2">Parsial</span></label>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label for="lingkar_perut_{{ $riwayat->id }}" class="block text-sm font-medium text-gray-700">Lingkar Perut (cm)</label>
                                            <input type="number" step="0.1" name="lingkar_perut" id="lingkar_perut_{{ $riwayat->id }}" value="{{ $riwayat->lingkar_perut ?? '' }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>

                                        <div class="mt-4">
                                            <label for="gula_darah_{{ $riwayat->id }}" class="block text-sm font-medium text-gray-700">Gula Darah (mg/dL)</label>
                                            <input type="number" step="0.1" name="gula_darah" id="gula_darah_{{ $riwayat->id }}" value="{{ $riwayat->gula_darah ?? '' }}" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>

                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700">Visus Mata</label>
                                            <div class="mt-2 space-x-4 flex">
                                                <label class="inline-flex items-center"><input type="radio" name="visus_mata" value="Normal" {{ ($riwayat->visus_mata ?? '') == 'Normal' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required><span class="ml-2">Normal</span></label>
                                                <label class="inline-flex items-center"><input type="radio" name="visus_mata" value="Gangguan" {{ ($riwayat->visus_mata ?? '') == 'Gangguan' ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" required><span class="ml-2">Gangguan</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Simpan</button>
                                        <button type="button" onclick="closeModal('modal-{{ $riwayat->id }}')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
