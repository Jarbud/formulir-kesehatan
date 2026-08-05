<x-app-layout>
    <x-slot:title>
        Formulir Pemeriksaan Kesehatan
    </x-slot:title>

    <x-slot:header>
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-primary-100 rounded-xl text-primary-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h2 class="font-bold text-xl sm:text-2xl text-gray-800 leading-tight">
                {{ __('Formulir Pemeriksaan Kesehatan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12 bg-gray-50 min-h-screen">
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl shadow-sm max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold">Gagal!</span>
                </div>
                <p class="text-sm mt-1">{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl shadow-sm max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <span class="font-bold">Terjadi kesalahan validasi</span>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div x-data="formWizard()" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Progress Stepper -->
            <div class="bg-white border-b border-gray-200 sticky top-16 z-40 shadow-sm rounded-t-2xl mb-0">
                <div class="py-4 sm:py-6 px-4 sm:px-8">
                    <div class="flex items-center justify-between max-w-2xl mx-auto">
                        <!-- Step 1 -->
                        <div class="flex items-center flex-1">
                            <button type="button" @click="goToStep(1)" class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full transition-all duration-300 font-bold text-sm"
                                :class="currentStep >= 1 ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'bg-gray-200 text-gray-500'">
                                1
                            </button>
                            <div class="ml-2 sm:ml-3 hidden sm:block">
                                <p class="text-xs font-medium" :class="currentStep >= 1 ? 'text-primary-600' : 'text-gray-500'">Langkah 1</p>
                                <p class="text-sm font-bold text-gray-900">Identitas</p>
                            </div>
                        </div>
                        
                        <!-- Connector -->
                        <div class="h-1 w-8 sm:w-16 mx-2 sm:mx-4 rounded-full transition-all duration-500" :class="currentStep >= 2 ? 'bg-primary-600' : 'bg-gray-200'"></div>
                        
                        <!-- Step 2 -->
                        <div class="flex items-center flex-1">
                            <button type="button" @click="goToStep(2)" class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full transition-all duration-300 font-bold text-sm"
                                :class="currentStep >= 2 ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'bg-gray-200 text-gray-500'">
                                2
                            </button>
                            <div class="ml-2 sm:ml-3 hidden sm:block">
                                <p class="text-xs font-medium" :class="currentStep >= 2 ? 'text-primary-600' : 'text-gray-500'">Langkah 2</p>
                                <p class="text-sm font-bold text-gray-900">Pemeriksaan Fisik</p>
                            </div>
                        </div>
                        
                        <!-- Connector -->
                        <div class="h-1 w-8 sm:w-16 mx-2 sm:mx-4 rounded-full transition-all duration-500" :class="currentStep >= 3 ? 'bg-primary-600' : 'bg-gray-200'"></div>
                        
                        <!-- Step 3 -->
                        <div class="flex items-center flex-1 justify-end">
                            <button type="button" @click="goToStep(3)" class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full transition-all duration-300 font-bold text-sm"
                                :class="currentStep >= 3 ? 'bg-primary-600 text-white shadow-lg shadow-primary-200' : 'bg-gray-200 text-gray-500'">
                                3
                            </button>
                            <div class="ml-2 sm:ml-3 hidden sm:block">
                                <p class="text-xs font-medium" :class="currentStep >= 3 ? 'text-primary-600' : 'text-gray-500'">Langkah 3</p>
                                <p class="text-sm font-bold text-gray-900">Riwayat</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Step Labels -->
                    <div class="sm:hidden text-center mt-3">
                        <p class="text-sm font-bold text-primary-600">
                            <span x-text="stepNames[currentStep - 1]"></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Header Form (Kop Surat) -->
            <div class="bg-white border-x border-gray-100 p-6 sm:p-8 shadow-sm">
                <div class="flex items-center justify-between border-b-2 border-gray-900 pb-4 mb-6">
                    <img src="{{ asset('images/logo-um.jpg') }}" class="h-12 sm:h-16 w-auto" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/7/7e/Logo_Universitas_Negeri_Malang.png/200px-Logo_Universitas_Negeri_Malang.png'" alt="Logo UM">
                    <div class="text-center flex-1 px-2 sm:px-4">
                        <h3 class="text-xs sm:text-sm lg:text-lg leading-tight uppercase font-medium">KEMENTERIAN PENDIDIKAN TINGGI, SAINS,</h3>
                        <h3 class="text-xs sm:text-sm lg:text-lg leading-tight uppercase font-medium">DAN TEKNOLOGI</h3>
                        <h3 class="font-bold text-sm sm:text-base lg:text-lg leading-tight uppercase">Universitas Negeri Malang (UM)</h3>
                        <p class="text-xs sm:text-sm font-semibold italic uppercase">UPT Layanan Kesehatan</p>
                        <p class="text-xs sm:text-sm font-semibold italic uppercase">Klinik Pratama</p>
                        <p class="text-[9px] sm:text-[10px] text-gray-500 hidden sm:block">Jl. Semarang 5, Malang 65145</p>
                        <p class="text-[9px] sm:text-[10px] text-gray-500 hidden sm:block">Telp: 0341-551312, Faksimile: 0341-551021</p>
                    </div>
                    <img src="{{ asset('images/logo-kecil.png') }}" class="h-12 sm:h-16 w-auto" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/7/7e/Logo_Universitas_Negeri_Malang.png/200px-Logo_Universitas_Negeri_Malang.png'" alt="Logo UM Kecil">
                </div>
                <div class="text-center">
                    <p class="font-bold text-xs sm:text-sm uppercase tracking-widest underline text-gray-700">Formulir Pemeriksaan Kesehatan Mahasiswa</p>
                </div>
            </div>

            <!-- Body Form -->
            <div class="bg-white p-6 sm:p-8 rounded-b-2xl shadow-md border-x border-b border-gray-100">
                <form method="POST" action="{{ route('simpan-data') }}" id="formulir-form">
                    @csrf

                    <!-- ==================== STEP 1: IDENTITAS ==================== -->
                    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3 pb-3 border-b-2 border-primary-100">
                                <div class="p-2 bg-primary-50 rounded-lg">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <h4 class="font-bold text-gray-900 text-base sm:text-lg">I. Identitas Mahasiswa</h4>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                <!-- Nama -->
                                <div class="relative sm:col-span-2">
                                    <label for="name" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" 
                                        class="input-base bg-gray-50 cursor-not-allowed" readonly required>
                                </div>

                                <!-- NIK & NIM -->
                                <div class="relative">
                                    <label for="nik" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">NIK <span class="text-red-500">*</span></label>
                                    <input type="text" id="nik" name="nik" class="input-base" placeholder="16 digit NIK" required maxlength="16">
                                </div>
                                <div class="relative">
                                    <label for="nim" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">NIM <span class="text-red-500">*</span></label>
                                    <input type="text" id="nim" name="nim" class="input-base" placeholder="Nomor Induk Mahasiswa" required>
                                </div>

                                <!-- JK & Usia -->
                                <div class="relative">
                                    <label for="jenis_kelamin" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="input-base" required>
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="relative">
                                    <label for="usia" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Usia <span class="text-red-500">*</span></label>
                                    <input type="number" id="usia" name="usia" class="input-base bg-gray-50 cursor-not-allowed" readonly placeholder="Otomatis" required>
                                </div>

                                <!-- Fakultas & Prodi -->
                                <div class="relative">
                                    <label for="select-fakultas" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Fakultas <span class="text-red-500">*</span></label>
                                    <select id="select-fakultas" name="fakultas" class="input-base" required onchange="updateProdi()">
                                        <option value="">-- Pilih Fakultas --</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="relative">
                                    <label for="select-prodi" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Program Studi <span class="text-red-500">*</span></label>
                                    <select id="select-prodi" name="prodi" class="input-base" disabled required>
                                        <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                                    </select>
                                </div>

                                <!-- Tempat Tanggal Lahir -->
                                <div class="relative sm:col-span-2">
                                    <label for="tempat_tanggal_lahir" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Tempat, Tanggal Lahir <span class="text-red-500">*</span></label>
                                    <input type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" placeholder="Contoh: Malang, 20 April 2003" class="input-base" required>
                                    <p class="text-xs text-gray-400 mt-1">Format: Kota, DD Bulan YYYY</p>
                                </div>

                                <!-- Alamat Asal -->
                                <div class="relative sm:col-span-2">
                                    <label for="alamat_asal" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Alamat Asal <span class="text-red-500">*</span></label>
                                    <input type="text" id="alamat_asal" name="alamat_asal" class="input-base" placeholder="Alamat lengkap sesuai KTP" required>
                                </div>

                                <!-- Alamat Malang -->
                                <div class="relative sm:col-span-2">
                                    <label for="alamat_malang" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Alamat Di Malang <span class="text-red-500">*</span></label>
                                    <input type="text" id="alamat_malang" name="alamat_malang" class="input-base" placeholder="Alamat kos / tempat tinggal di Malang" required>
                                </div>

                                <!-- WA & WA Wali -->
                                <div class="relative">
                                    <label for="wa" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">No. WhatsApp <span class="text-red-500">*</span></label>
                                    <input type="text" id="wa" name="wa" class="input-base" placeholder="08xxx" required>
                                </div>
                                <div class="relative">
                                    <label for="wa_wali" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">No. WA Orang Tua/Wali <span class="text-red-500">*</span></label>
                                    <input type="text" id="wa_wali" name="wa_wali" class="input-base" placeholder="08xxx" required>
                                </div>

                                <!-- Nama Wali -->
                                <div class="relative sm:col-span-2">
                                    <label for="nama_wali" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Nama Orang Tua / Wali <span class="text-red-500">*</span></label>
                                    <input type="text" id="nama_wali" name="nama_wali" class="input-base" placeholder="Nama lengkap orang tua / wali" required>
                                </div>

                                <!-- Skrining & Disabilitas -->
                                <div class="relative">
                                    <label for="skrining_kesehatan_mental" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Skrining Kesehatan Mental <span class="text-red-500">*</span></label>
                                    <select name="skrining_kesehatan_mental" id="skrining_kesehatan_mental" class="input-base" required>
                                        <option value="Belum" selected>Belum</option>
                                        <option value="Sudah">Sudah</option>
                                    </select>
                                </div>
                                <div class="relative">
                                    <label for="disabilitas" class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Disabilitas</label>
                                    <select name="disabilitas" id="disabilitas" class="input-base">
                                        <option value="Tidak Ada" selected>Tidak Ada</option>
                                        <option value="Ada">Ada</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== STEP 2: PEMERIKSAAN FISIK ==================== -->
                    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3 pb-3 border-b-2 border-primary-100">
                                <div class="p-2 bg-primary-50 rounded-lg">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <h4 class="font-bold text-gray-900 text-base sm:text-lg">II. Pemeriksaan Fisik</h4>
                            </div>
                            
                            <!-- Tinggi & Berat -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <label for="tinggi_badan" class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
                                    <input type="number" id="tinggi_badan" name="tinggi_badan" class="input-base" placeholder="173" required min="50" max="250">
                                </div>
                                <div class="relative">
                                    <label for="berat_badan" class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Berat Badan (kg) <span class="text-red-500">*</span></label>
                                    <input type="number" id="berat_badan" name="berat_badan" class="input-base" placeholder="65" required min="10" max="300">
                                </div>
                            </div>

                            <!-- IMT Calculator Card -->
                            <div class="bg-gradient-to-br from-blue-50 via-primary-50 to-accent-50 p-5 sm:p-6 rounded-2xl border-2 border-primary-100 shadow-lg">
                                <div class="flex items-center space-x-2 mb-4">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <h5 class="font-bold text-gray-900">Indeks Massa Tubuh (IMT)</h5>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <!-- IMT Value Display -->
                                    <div class="flex-1">
                                        <p class="text-4xl sm:text-5xl font-black text-gray-900 transition-all duration-500" id="imt_result_display">0.0</p>
                                        <input type="hidden" id="imt_result" name="imt" value="">
                                        <p id="status_imt" class="text-base sm:text-lg font-bold mt-2 text-gray-400 transition-all duration-300">Masukkan tinggi & berat badan</p>
                                    </div>
                                    
                                    <!-- IMT Gauge SVG -->
                                    <div class="w-28 h-28 sm:w-36 sm:h-36 flex-shrink-0">
                                        <svg viewBox="0 0 120 120" class="w-full h-full">
                                            <circle cx="60" cy="60" r="50" fill="none" stroke="#e5e7eb" stroke-width="12" />
                                            <circle id="imt-gauge" cx="60" cy="60" r="50" fill="none" 
                                                    stroke="#d1d5db" stroke-width="12" 
                                                    stroke-dasharray="314" stroke-dashoffset="314"
                                                    stroke-linecap="round"
                                                    class="transition-all duration-700 ease-out"
                                                    transform="rotate(-90 60 60)"/>
                                            <text x="60" y="58" text-anchor="middle" class="text-[10px] font-bold fill-gray-400" id="gauge-label">IMT</text>
                                            <text x="60" y="72" text-anchor="middle" class="text-[8px] fill-gray-400" id="gauge-sublabel">kg/m2</text>
                                        </svg>
                                    </div>
                                </div>

                                <!-- IMT Range Reference -->
                                <div class="mt-4 grid grid-cols-4 gap-2 text-center">
                                    <div class="p-2 rounded-lg" id="ref-underweight">
                                        <div class="w-full h-1.5 bg-blue-400 rounded-full mb-1.5"></div>
                                        <p class="text-[10px] sm:text-xs font-bold text-gray-700">&lt; 18.5</p>
                                        <p class="text-[9px] sm:text-[10px] text-gray-500">Kurus</p>
                                    </div>
                                    <div class="p-2 rounded-lg" id="ref-normal">
                                        <div class="w-full h-1.5 bg-green-500 rounded-full mb-1.5"></div>
                                        <p class="text-[10px] sm:text-xs font-bold text-gray-700">18.5 - 24.9</p>
                                        <p class="text-[9px] sm:text-[10px] text-gray-500">Normal</p>
                                    </div>
                                    <div class="p-2 rounded-lg" id="ref-overweight">
                                        <div class="w-full h-1.5 bg-yellow-500 rounded-full mb-1.5"></div>
                                        <p class="text-[10px] sm:text-xs font-bold text-gray-700">25 - 29.9</p>
                                        <p class="text-[9px] sm:text-[10px] text-gray-500">Gemuk</p>
                                    </div>
                                    <div class="p-2 rounded-lg" id="ref-obese">
                                        <div class="w-full h-1.5 bg-red-500 rounded-full mb-1.5"></div>
                                        <p class="text-[10px] sm:text-xs font-bold text-gray-700">>= 30</p>
                                        <p class="text-[9px] sm:text-[10px] text-gray-500">Obesitas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== STEP 3: RIWAYAT ==================== -->
                    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3 pb-3 border-b-2 border-primary-100">
                                <div class="p-2 bg-primary-50 rounded-lg">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h4 class="font-bold text-gray-900 text-base sm:text-lg">III. Riwayat dan Keluhan</h4>
                            </div>

                            <!-- Riwayat Sakit -->
                            <div class="relative">
                                <label for="riwayat_sakit" class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Riwayat Sakit</label>
                                <input type="text" id="riwayat_sakit" name="riwayat_sakit" class="input-base" placeholder="Contoh: Maag / Tidak ada">
                            </div>

                            <!-- Riwayat Kesehatan Fisik -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-1">
                                    Riwayat kesehatan fisik (dari kecil sampai dewasa) <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 italic mb-4">Centang yang pernah Anda alami</p>

                                <!-- Tidak Ada Checkbox -->
                                <div class="mb-4">
                                    <label class="flex items-start p-4 bg-accent-50 rounded-xl border-2 border-accent-200 cursor-pointer hover:bg-accent-100 transition-all duration-200">
                                        <input id="riwayat_tidak_ada" name="riwayat_kesehatan_fisik" type="checkbox" value="Tidak ada" 
                                            class="h-5 w-5 text-accent-600 border-gray-300 rounded focus:ring-accent-500 mt-0.5"
                                            onchange="toggleRiwayatNone(this)">
                                        <span class="ml-3 text-sm font-bold text-accent-800">Tidak ada riwayat kesehatan fisik</span>
                                    </label>
                                </div>

                                <!-- Checklist Grid -->
                                @php
                                    $riwayatList = [
                                        'Riwayat sering sakit kepala berulang',
                                        'Riwayat jatuh terbentur pada kepala',
                                        'Riwayat kejang',
                                        'Riwayat penyakit paru-paru',
                                        'Riwayat batuk berulang/lama lebih dari 1 bulan',
                                        'Riwayat penyakit asma/sesak',
                                        'Riwayat sering pingsan',
                                        'Riwayat operasi/dirawat di rumah sakit',
                                        'Riwayat penyakit saluran pencernaan',
                                        'Riwayat muntah darah',
                                        'Riwayat berak darah',
                                        'Riwayat batuk darah',
                                        'Riwayat penyakit jantung',
                                        'Riwayat keringat dingin tangan/kaki',
                                        'Riwayat biru pada bibir/tangan/kaki',
                                        'Riwayat demam berulang selama sekitar 2 bulan',
                                        'Riwayat diare berulang selama sekitar 2 bulan',
                                        'Riwayat sariawan berulang selama sekitar 2 bulan',
                                        'Riwayat kesemutan yang berulang dan terus menerus',
                                        'Riwayat gangguan pendengaran/telinga',
                                        'Riwayat gangguan penglihatan/mata'
                                    ];
                                @endphp

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($riwayatList as $index => $riwayat)
                                        <label class="checkbox-item flex items-start p-3 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-100 hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                                            <input id="riwayat_{{ $index }}" name="riwayat_kesehatan[]" type="checkbox" value="{{ $riwayat }}" 
                                                class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mt-0.5">
                                            <span class="ml-3 text-sm text-gray-700 font-medium">{{ $riwayat }}</span>
                                        </label>
                                    @endforeach

                                    <!-- Other -->
                                    <div class="sm:col-span-2 p-4 bg-gray-50 rounded-xl border border-gray-200">
                                        <label class="flex items-center cursor-pointer">
                                            <input id="riwayat_other_checkbox" type="checkbox" class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500" onchange="toggleOtherInput(this)">
                                            <span class="ml-3 text-sm font-medium text-gray-700">Other / Lainnya:</span>
                                        </label>
                                        <input type="text" id="riwayat_other_text" name="riwayat_kesehatan_other" placeholder="Sebutkan riwayat kesehatan lainnya jika ada..." 
                                            class="w-full mt-3 p-3 text-sm border border-gray-300 rounded-lg bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all duration-200 opacity-50" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Keluhan -->
                            <div class="relative">
                                <label for="keluhan" class="block text-xs font-bold text-gray-700 uppercase mb-1.5">Keluhan Saat Ini</label>
                                <textarea id="keluhan" name="keluhan" rows="3" class="input-base resize-none" placeholder="Jelaskan keluhan kesehatan yang Anda rasakan saat ini..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4 mt-8 pt-6 border-t border-gray-200">
                        <button type="button" @click="prevStep()" 
                            x-show="currentStep > 1"
                            x-transition
                            class="btn-secondary w-full sm:w-auto">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Sebelumnya
                        </button>
                        
                        <div x-show="currentStep === 1"></div>

                        <button type="button" @click="nextStep()" 
                            x-show="currentStep < 3"
                            x-transition
                            class="btn-primary w-full sm:w-auto">
                            Selanjutnya
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>

                        <!-- Submit Button (only on step 3) -->
                        <button type="submit" 
                            x-show="currentStep === 3"
                            x-transition
                            x-data="{ loading: false }"
                            @click="loading = true"
                            :disabled="loading"
                            :class="loading ? 'opacity-75 cursor-not-allowed' : ''"
                            class="group relative w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl font-bold text-base hover:from-primary-700 hover:to-primary-800 transition-all duration-300 shadow-lg shadow-primary-600/30 hover:shadow-xl hover:shadow-primary-600/40 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <span x-show="loading" class="absolute left-4 top-1/2 -translate-y-1/2">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </span>
                            <span :class="loading ? 'opacity-0' : ''" class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan & Bayar
                            </span>
                            <span x-show="loading" class="absolute inset-0 flex items-center justify-center font-semibold">
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        // ==================== FORM WIZARD ====================
        function formWizard() {
            return {
                currentStep: 1,
                stepNames: ['Identitas Mahasiswa', 'Pemeriksaan Fisik', 'Riwayat & Keluhan'],
                
                nextStep() {
                    if (this.currentStep < 3) this.currentStep++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },
                
                prevStep() {
                    if (this.currentStep > 1) this.currentStep--;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },
                
                goToStep(step) {
                    if (step <= this.currentStep) {
                        this.currentStep = step;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                }
            };
        }

        // ==================== IMT CALCULATOR ====================
        const tinggiInput = document.getElementById('tinggi_badan');
        const beratInput = document.getElementById('berat_badan');
        const imtResult = document.getElementById('imt_result');
        const imtResultDisplay = document.getElementById('imt_result_display');
        const statusImt = document.getElementById('status_imt');
        const gaugeCircle = document.getElementById('imt-gauge');
        const gaugeLabel = document.getElementById('gauge-label');
        const gaugeSublabel = document.getElementById('gauge-sublabel');
        const circumference = 314;

        function hitungIMT() {
            const tinggi = tinggiInput.value / 100;
            const berat = beratInput.value;

            if (tinggi > 0 && berat > 0) {
                const imt = (berat / (tinggi * tinggi)).toFixed(1);
                imtResult.value = imt;
                imtResultDisplay.innerText = imt;

                let statusText, statusColor, gaugeColor, gaugeFill, labelColor;

                if (imt < 18.5) {
                    statusText = 'Kurus (Underweight)';
                    statusColor = 'text-blue-600';
                    gaugeColor = '#60a5fa';
                    labelColor = '#3b82f6';
                    gaugeFill = 0.3;
                } else if (imt >= 18.5 && imt <= 24.9) {
                    statusText = 'Normal (Sehat)';
                    statusColor = 'text-green-600';
                    gaugeColor = '#10b981';
                    labelColor = '#059669';
                    gaugeFill = 0.55;
                } else if (imt >= 25 && imt <= 29.9) {
                    statusText = 'Gemuk (Overweight)';
                    statusColor = 'text-yellow-600';
                    gaugeColor = '#f59e0b';
                    labelColor = '#d97706';
                    gaugeFill = 0.78;
                } else {
                    statusText = 'Obesitas';
                    statusColor = 'text-red-600';
                    gaugeColor = '#ef4444';
                    labelColor = '#dc2626';
                    gaugeFill = 1;
                }

                statusImt.innerText = statusText;
                statusImt.className = 'text-base sm:text-lg font-bold mt-2 transition-all duration-300 ' + statusColor;

                // Animate gauge
                const offset = circumference * (1 - gaugeFill);
                gaugeCircle.style.strokeDashoffset = offset;
                gaugeCircle.style.stroke = gaugeColor;
                gaugeLabel.style.fill = labelColor;
                gaugeSublabel.style.fill = labelColor;

                // Highlight active range reference
                document.querySelectorAll('[id^="ref-"]').forEach(el => el.classList.remove('ring-2', 'ring-offset-2', 'shadow-md'));
                if (imt < 18.5) document.getElementById('ref-underweight').classList.add('ring-2', 'ring-blue-400', 'ring-offset-2', 'shadow-md');
                else if (imt <= 24.9) document.getElementById('ref-normal').classList.add('ring-2', 'ring-green-400', 'ring-offset-2', 'shadow-md');
                else if (imt <= 29.9) document.getElementById('ref-overweight').classList.add('ring-2', 'ring-yellow-400', 'ring-offset-2', 'shadow-md');
                else document.getElementById('ref-obese').classList.add('ring-2', 'ring-red-400', 'ring-offset-2', 'shadow-md');
            }
        }

        tinggiInput.addEventListener('input', hitungIMT);
        beratInput.addEventListener('input', hitungIMT);

        // ==================== FAKULTAS & PRODI ====================
        const masterData = {!! json_encode($faculties) !!};

        function updateProdi() {
            const fakultasSelect = document.getElementById('select-fakultas');
            const prodiSelect = document.getElementById('select-prodi');
            const selectedFacultyId = fakultasSelect.value;

            prodiSelect.innerHTML = '';

            if (selectedFacultyId) {
                const activeFaculty = masterData.find(f => f.id == selectedFacultyId);

                if (activeFaculty && activeFaculty.program_studis.length > 0) {
                    prodiSelect.disabled = false;
                    let defaultOpt = document.createElement('option');
                    defaultOpt.value = "";
                    defaultOpt.text = "-- Pilih Program Studi --";
                    prodiSelect.appendChild(defaultOpt);

                    activeFaculty.program_studis.forEach(function(prodi) {
                        let opt = document.createElement('option');
                        const fullProdiName = `${prodi.level} ${prodi.name}`;
                        opt.value = fullProdiName;
                        opt.text = fullProdiName;
                        prodiSelect.appendChild(opt);
                    });
                } else {
                    prodiSelect.disabled = true;
                    let opt = document.createElement('option');
                    opt.value = "";
                    opt.text = "-- Tidak ada prodi tersedia --";
                    prodiSelect.appendChild(opt);
                }
            } else {
                prodiSelect.disabled = true;
                let opt = document.createElement('option');
                opt.value = "";
                opt.text = "-- Pilih Fakultas Terlebih Dahulu --";
                prodiSelect.appendChild(opt);
            }
        }

        // ==================== RIWAYAT CHECKBOX LOGIC ====================
        function toggleRiwayatNone(src) {
            const checkboxes = document.querySelectorAll('.checkbox-item input[type="checkbox"]');
            const otherCheckbox = document.getElementById('riwayat_other_checkbox');
            const otherText = document.getElementById('riwayat_other_text');

            if (src.checked) {
                checkboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                    cb.closest('label').classList.add('opacity-40');
                });
                otherCheckbox.checked = false;
                otherCheckbox.disabled = true;
                otherText.value = '';
                otherText.disabled = true;
                otherText.classList.add('opacity-40');
            } else {
                checkboxes.forEach(cb => {
                    cb.disabled = false;
                    cb.closest('label').classList.remove('opacity-40');
                });
                otherCheckbox.disabled = false;
            }
        }

        function toggleOtherInput(src) {
            const otherText = document.getElementById('riwayat_other_text');
            if (src.checked) {
                otherText.disabled = false;
                otherText.classList.remove('opacity-40', 'opacity-50');
                otherText.focus();
            } else {
                otherText.disabled = true;
                otherText.value = '';
                otherText.classList.add('opacity-40');
            }
        }

        // ==================== USIA CALCULATOR ====================
        const tempatTanggalLahirInput = document.getElementById('tempat_tanggal_lahir');
        const usiaInput = document.getElementById('usia');

        tempatTanggalLahirInput.addEventListener('input', function() {
            const inputVal = this.value;
            const parts = inputVal.split(',');
            
            if (parts.length > 1) {
                let dateStr = parts[parts.length - 1].trim(); 
                
                const bulanIdEn = {
                    'januari': 'January', 'februari': 'February', 'maret': 'March', 'april': 'April',
                    'mei': 'May', 'juni': 'June', 'juli': 'July', 'agustus': 'August',
                    'september': 'September', 'oktober': 'October', 'november': 'November', 'desember': 'December'
                };

                let engDateStr = dateStr.toLowerCase();
                for (const [id, en] of Object.entries(bulanIdEn)) {
                    engDateStr = engDateStr.replace(id, en.toLowerCase());
                }

                const dob = new Date(engDateStr);
                
                if (!isNaN(dob.getTime())) {
                    const today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    const m = today.getMonth() - dob.getMonth();
                    
                    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    
                    if(age >= 0 && age < 150) { 
                        usiaInput.value = age;
                    } else {
                        usiaInput.value = '';
                    }
                } else {
                    usiaInput.value = '';
                }
            } else {
                usiaInput.value = '';
            }
        });
    </script>
</x-app-layout>
