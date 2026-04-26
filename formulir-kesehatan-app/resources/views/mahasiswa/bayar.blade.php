<x-app-layout>
    <x-slot:title>
        Pembayaran Pemeriksaan
    </x-slot:title>

    <x-slot:header>
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-green-100 rounded-lg text-green-900">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Pembayaran Pemeriksaan Kesehatan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Form (Kop Surat Mockup) -->
            <div class="bg-white border-b border-gray-200 p-8 rounded-t-2xl shadow-sm">
                <div class="flex items-center justify-between border-b-2 border-gray-900 pb-4 mb-6">
                    <img src="{{ asset('images/logo-kecil.png') }}" class="h-16 w-auto" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/7/7e/Logo_Universitas_Negeri_Malang.png/200px-Logo_Universitas_Negeri_Malang.png'">
                    <div class="text-center flex-1">
                        <h3 class="font-bold text-lg leading-tight uppercase">Universitas Negeri Malang</h3>
                        <p class="text-sm font-semibold italic uppercase">UPT Layanan Kesehatan - Klinik Pratama</p>
                        <p class="text-[10px] text-gray-500">Jl. Semarang 5, Malang 65145 | Telp: 0341-551312</p>
                    </div>
                    <!-- <div class="w-16 h-16 flex items-center justify-center border-2 border-blue-900 rounded-full text-blue-900 font-black">UM</div> -->
                </div>
                <div class="text-center italic text-sm text-gray-700">
                    <p class="font-bold uppercase tracking-widest underline">Instruksi Pembayaran Pemeriksaan</p>
                </div>
            </div>

            <!-- Body Content -->
            <div class="bg-white p-8 rounded-b-2xl shadow-md border-x border-b border-gray-100">
                <div class="text-center space-y-6">
                    
                    <!-- Alert Info -->
                    <div class="bg-yellow-50 text-yellow-800 p-4 rounded-xl inline-block border border-yellow-200">
                        <p class="font-semibold text-sm">Formulir Anda telah tersimpan. Selesaikan pembayaran agar formulir dapat diproses.</p>
                    </div>

                    <!-- Nominal Pembayaran -->
                    <div class="py-4">
                        <p class="text-gray-500 font-bold uppercase tracking-wider text-xs mb-1">Total Tagihan</p>
                        <h3 class="text-4xl font-black text-gray-900">Rp 50.000</h3>
                    </div>

                    <!-- QRIS Mockup -->
                    <div class="flex justify-center">
                        <div class="p-6 bg-white border-2 border-dashed border-gray-300 rounded-3xl shadow-sm relative">
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-white px-4">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" alt="QRIS Logo" class="h-6">
                            </div>
                            <!-- Gambar Dummy QR Code -->
                            <img src="{{ asset('images/qris.jpeg') }}" alt="QR Code QRIS" class="w-64 h-64 object-cover rounded-xl mt-2">
                            <p class="mt-4 font-bold text-blue-900 uppercase tracking-widest text-sm">Klinik Pratama UM</p>
                            <p class="text-xs text-gray-500 font-semibold">NMID: ID1029384756</p>
                        </div>
                    </div>

                    <!-- Cara Pembayaran -->
                    <div class="bg-gray-50 p-6 rounded-2xl max-w-2xl mx-auto text-left border border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-4 flex items-center">
                            <i data-lucide="info" class="w-5 h-5 mr-2 text-blue-600"></i> Cara Pembayaran
                        </h4>
                        <ol class="list-decimal list-inside text-sm text-gray-600 space-y-3 font-medium">
                            <li>Buka aplikasi m-banking atau e-wallet Anda (Gopay, OVO, Dana, LinkAja, dll).</li>
                            <li>Pilih menu <strong>Scan QRIS</strong>.</li>
                            <li>Arahkan kamera ke kode QR di atas.</li>
                            <li>Pastikan nama merchant adalah <strong>Klinik Pratama UM</strong> dengan nominal <strong>Rp 50.000</strong>.</li>
                            <li>Selesaikan pembayaran dan upload bukti pembayaran di bawah ini.</li>
                        </ol>
                    </div>

                    <!-- Form Upload & Action Buttons -->
                    <form method="POST" action="{{ route('upload-bukti') }}" enctype="multipart/form-data" class="mt-8">
                        @csrf
                        <input type="hidden" name="pemeriksaan_id" value="{{ $pemeriksaan->id }}">

                        <!-- Upload Bukti -->
                        <div class="max-w-2xl mx-auto mb-8 p-6 bg-white border-2 border-dashed border-gray-300 rounded-2xl text-center hover:bg-gray-50 transition">
                            <label for="bukti_pembayaran" class="block font-bold text-gray-800 mb-2">Upload Bukti Pembayaran</label>
                            <p class="text-xs text-gray-500 mb-4">Format yang didukung: JPG, PNG, PDF (Maks. 2MB)</p>
                            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*,.pdf" required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-center space-x-4 border-t pt-8 mt-4">
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 border-2 border-gray-200 rounded-xl text-gray-700 font-bold hover:bg-gray-50 hover:border-gray-300 transition">
                                Kembali ke Dashboard
                            </a>
                            <button type="submit" id="btn_submit_bayar" class="hidden items-center px-8 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-200">
                                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i> Saya Sudah Bayar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Script Rendering Icon -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons(); // Inisialisasi agar ikon lucide muncul

        const inputBukti = document.getElementById('bukti_pembayaran');
        const btnSubmit = document.getElementById('btn_submit_bayar');

        inputBukti.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                btnSubmit.classList.remove('hidden');
                btnSubmit.classList.add('flex');
            } else {
                btnSubmit.classList.add('hidden');
                btnSubmit.classList.remove('flex');
            }
        });
    </script>
</x-app-layout>