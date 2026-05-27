<x-guest-layout>
    <div class="flex flex-col items-center justify-center py-6 px-4">
        <!-- Logo Klinik -->
        <img src="{{ asset('images/logo-kecil.png') }}" alt="Logo Klinik" class="w-24 h-24 mb-6 object-contain">
        
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Validasi Tanda Tangan</h2>
        
        <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-center font-bold mb-8 flex items-center justify-center gap-2 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Dokumen Terverifikasi
        </div>

        <div class="w-full text-left space-y-5 bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Peran / Jabatan</p>
                <p class="text-lg text-gray-900 font-semibold">{{ $nakes->role }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">Nama Lengkap</p>
                <p class="text-lg text-gray-900 font-semibold">{{ $nakes->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1">{{ $nakes->role === 'Dokter Penanggungjawab' ? 'SIP' : 'NIP' }}</p>
                <p class="text-lg text-gray-900 font-semibold">{{ $nakes->nip }}</p>
            </div>
        </div>

        <div class="mt-8 text-center text-sm font-medium text-gray-500 border-t border-gray-200 pt-6 w-full">
            Klinik Pratama Universitas Negeri Malang
        </div>
    </div>
</x-guest-layout>
