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
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-4">Tanggal</th>
                                    <th class="px-6 py-4">NIM</th>
                                    <th class="px-6 py-4">Status Pembayaran</th>
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
                                        <td class="px-6 py-4">
                                            @if($riwayat->status_pembayaran == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Belum Bayar</span>
                                            @elseif($riwayat->status_pembayaran == 'menunggu_verifikasi')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                                            @elseif($riwayat->status_pembayaran == 'lunas')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Lunas</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($riwayat->status_pembayaran) }}</span>
                                            @endif
                                        </td>
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
                                            <a href="{{ route('admin.cetak.formulir', $riwayat->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 rounded-md text-xs font-bold transition">
                                                Lihat PDF Formulir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
