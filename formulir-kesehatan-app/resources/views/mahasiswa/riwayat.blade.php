<x-app-layout>
    <x-slot:title>
        Riwayat Pemeriksaan
    </x-slot:title>

    <x-slot:header>
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-indigo-100 rounded-lg text-indigo-900">
                <i data-lucide="history" class="w-6 h-6"></i>
            </div>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Pemeriksaan Kesehatan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Daftar Riwayat Formulir Anda</h3>
                    
                    @if($riwayats->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4 text-gray-400">
                                <i data-lucide="folder-open" class="w-8 h-8"></i>
                            </div>
                            <h3 class="text-gray-900 font-bold text-lg">Belum ada riwayat</h3>
                            <p class="text-gray-500 mt-1">Anda belum pernah mengisi formulir pemeriksaan kesehatan.</p>
                            <a href="{{ route('formulir') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                Isi Formulir Sekarang
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-y border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        <th class="px-6 py-4">Tanggal Pengisian</th>
                                        <th class="px-6 py-4">Nama Lengkap</th>
                                        <th class="px-6 py-4">NIM</th>
                                        <!-- <th class="px-6 py-4">Status Pembayaran</th> -->
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
                                                {{ $riwayat->name }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                {{ $riwayat->nim }}
                                            </td>
                                            <!-- <td class="px-6 py-4">
                                                @if($riwayat->status_pembayaran == 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Belum Bayar
                                                    </span>
                                                @elseif($riwayat->status_pembayaran == 'menunggu_verifikasi')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Menunggu Verifikasi
                                                    </span>
                                                @elseif($riwayat->status_pembayaran == 'lunas')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Lunas
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ ucfirst($riwayat->status_pembayaran) }}
                                                    </span>
                                                @endif
                                            </td> -->
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('cetak.formulir', $riwayat->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 font-semibold text-sm inline-flex items-center">
                                                    <i data-lucide="eye" class="w-4 h-4 mr-1"></i> Lihat PDF
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
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
