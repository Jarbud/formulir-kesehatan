<x-app-layout>
    <x-slot:title>
        Formulir Pemeriksaan Kesehatan
    </x-slot:title>

    <x-slot:header>
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-100 rounded-lg text-blue-900">
                <i data-lucide="file-text" class="w-6 h-6"></i>
            </div>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Formulir Pemeriksaan Kesehatan Mahasiswa') }}
            </h2>
        </div>
    </x-slot>

    
    <div class="py-12 bg-gray-50">
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold">Gagal!</span>
                </div>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        @endif
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
                    <p class="font-bold uppercase tracking-widest underline">Formulir Pemeriksaan Kesehatan Mahasiswa</p>
                </div>
            </div>

            <!-- Body Form -->
            <div class="bg-white p-8 rounded-b-2xl shadow-md border-x border-b border-gray-100">
                <form method="POST" action="{{ route('simpan-data') }}" class="space-y-8">
                    @csrf
                    
                    <!-- 1. Identitas (Read Only - Diambil dari Auth) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h4 class="font-bold text-blue-900 border-b pb-1 text-sm uppercase tracking-wider">I. Identitas Mahasiswa</h4>
                            
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">NIK</label>
                                    <input type="text" name="nik" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">NIM</label>
                                    <input type="text" name="nim" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Usia</label>
                                    <input type="number" name="usia" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Fakultas</label>
                                    <select name="fakultas" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                        <option value="FIP">FIP</option>
                                        <option value="FS">FS</option>
                                        <option value="FEB">FEB</option>
                                        <option value="FT">FT</option>
                                        <option value="FIK">FIK</option>
                                        <option value="FIS">FIS</option>
                                        <option value="FK">FK</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Prodi</label>
                                    <select name="prodi" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                        <option value="S1 Bimbingan dan Konseling">S1 Bimbingan dan Konseling</option>
                                        <option value="S1 Teknologi Penelitian">S1 Teknologi Penelitian</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Tempat, Tanggal Lahir</label>
                                <input type="text" name="tempat_tanggal_lahir" placeholder="Malang, 20 April 2000" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Disabilitas</label>
                                <select name="disabilitas" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                    <option value="Tidak Ada" selected>Tidak Ada</option>
                                    <option value="Ada">Ada</option>
                                </select>
                            </div>
                        </div>

                        <!-- 2. Data Fisik (Input) -->
                        <div class="space-y-4">
                            <h4 class="font-bold text-blue-900 border-b pb-1 text-sm uppercase tracking-wider">II. Pemeriksaan Fisik (Diisi Petugas)</h4>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-700 uppercase">Tinggi Badan (cm)</label>
                                    <input type="number" id="tinggi_badan" name="tinggi_badan" class="mt-1 border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 173" required>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-700 uppercase">Berat Badan (kg)</label>
                                    <input type="number" id="berat_badan" name="berat_badan" class="mt-1 border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 78" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 bg-blue-50 p-3 rounded-xl border border-blue-100">
                                <div class="flex flex-col">
                                    <label class="text-[10px] font-bold text-blue-600 uppercase">Nilai IMT</label>
                                    <input type="text" id="imt_result" name="imt" class="bg-transparent border-none p-0 font-black text-xl text-blue-900 focus:ring-0" readonly placeholder="0.0">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-[10px] font-bold text-blue-600 uppercase">Status</label>
                                    <span id="status_imt" class="font-bold text-sm text-gray-700 mt-1">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Hasil Medis Lanjutan -->
                    <div class="space-y-4">
                        <h4 class="font-bold text-blue-900 border-b pb-1 text-sm uppercase tracking-wider">III. Riwayat dan Keluhan</h4>
                        <div class="flex flex-col">
                            <label class="text-xs font-bold text-gray-700 uppercase">Riwayat Sakit</label>
                            <input type="text" name="riwayat_sakit" class="mt-1 border-gray-300 rounded-lg p-2" placeholder="Contoh: Maag / Tidak ada">
                        </div>

                        <div class="flex flex-col">
                            <label class="text-xs font-bold text-gray-700 uppercase">Keluhan Saat Ini</label>
                            <textarea name="keluhan" rows="2" class="mt-1 border-gray-300 rounded-lg p-2" placeholder="Isi jika ada keluhan..."></textarea>
                        </div>
                    </div>


                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 border-t pt-8">
                        <!-- <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition">
                            Draft (Simpan Sementara)
                        </button> -->
                        <button type="submit" class="px-8 py-2 bg-blue-900 text-white rounded-lg font-bold hover:bg-blue-800 transition shadow-lg shadow-blue-200">
                            Simpan & Bayar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Script Rendering Icon & Kalkulasi Otomatis -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons(); // Inisialisasi agar ikon lucide muncul

        const tinggiInput = document.getElementById('tinggi_badan');
        const beratInput = document.getElementById('berat_badan');
        const imtResult = document.getElementById('imt_result');
        const statusImt = document.getElementById('status_imt');

        function hitungIMT() {
            const tinggi = tinggiInput.value / 100; // ubah ke meter
            const berat = beratInput.value;

            if (tinggi > 0 && berat > 0) {
                const imt = (berat / (tinggi * tinggi)).toFixed(1);
                imtResult.value = imt;

                if (imt < 18.5) {
                    statusImt.innerText = 'Underweight';
                    statusImt.className = 'font-bold text-sm text-blue-600 mt-1';
                } else if (imt >= 18.5 && imt <= 24.9) {
                    statusImt.innerText = 'Normal';
                    statusImt.className = 'font-bold text-sm text-green-600 mt-1';
                } else if (imt >= 25 && imt <= 29.9) {
                    statusImt.innerText = 'Overweight';
                    statusImt.className = 'font-bold text-sm text-orange-600 mt-1';
                } else {
                    statusImt.innerText = 'Obesity';
                    statusImt.className = 'font-bold text-sm text-red-600 mt-1';
                }
            }
        }

        tinggiInput.addEventListener('input', hitungIMT);
        beratInput.addEventListener('input', hitungIMT);
    </script>
</x-app-layout>