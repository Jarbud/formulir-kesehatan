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
                    <img src="{{ asset('images/logo-um.jpg') }}" class="h-16 w-auto" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/7/7e/Logo_Universitas_Negeri_Malang.png/200px-Logo_Universitas_Negeri_Malang.png'">
                    <div class="text-center flex-1">
                        <h3 class="text-lg leading-tight uppercase">KEMENTERIAN PENDIDIKAN TINGGI, SAINS,</h3>
                        <h3 class="text-lg leading-tight uppercase">DAN TEKNOLOGI</h3>
                        <h3 class="font-bold text-lg leading-tight uppercase">Universitas Negeri Malang (UM)</h3>
                        <p class="text-sm font-semibold italic uppercase">UPT Layanan Kesehatan</p>
                        <p class="text-sm font-semibold italic uppercase">Klinik Pratama</p>
                        <p class="text-[10px] text-gray-500">Jl. Semarang 5, Malang 65145</p>
                        <p class="text-[10px] text-gray-500">Telp: 0341-551312, Faksimile: 0341-551021</p>
                        <p class="text-[10px] text-gray-500">Laman: www.um.ac.id</p>
                    </div>
<img src="{{ asset('images/logo-kecil.png') }}" class="h-16 w-auto" onerror="this.src='https://upload.wikimedia.org/wikipedia/id/thumb/7/7e/Logo_Universitas_Negeri_Malang.png/200px-Logo_Universitas_Negeri_Malang.png'">
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
                                <label class="text-xs font-bold text-gray-500 uppercase">Nama Lengkap <span style="color: red;">*</span><label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">NIK <span style="color: red;">*</span></label>
                                    <input type="text" name="nik" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">NIM <span style="color: red;">*</span></label>
                                    <input type="text" name="nim" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Jenis Kelamin <span style="color: red;">*</span></label>
                                    <select name="jenis_kelamin" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                        <option value="laki-laki">Laki-laki</option>
                                        <option value="perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Usia <span style="color: red;">*</span></label>
                                    <input type="number" id="usia" name="usia" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800" readonly>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Fakultas <span style="color: red;">*</span></label>
                                    <select id="select-fakultas" name="fakultas" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800" onchange="updateProdi()">
                                        <option value="">-- Pilih Fakultas --</option>
                                        @foreach($faculties as $faculty)
                                            {{-- value menggunakan ID, teks dropdown menggunakan nama lengkap fakultas --}}
                                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-500 uppercase">Prodi <span style="color: red;">*</span></label>
                                    <select id="select-prodi" name="prodi" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800" disabled>
                                        <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Tempat, Tanggal Lahir <span style="color: red;">*</span></label>
                                <input type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" placeholder="Malang, 20 April 2000" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Alamat Asal <span style="color: red;">*</span></label>
                                <input required type="text" name="alamat_asal" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Alamat Di Malang <span style="color: red;">*</span></label>
                                <input required type="text" name="alamat_malang" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Nomor Whatsapp yang dapat dihubungi <span style="color: red;">*</span></label>
                                <input required type="text" name="wa" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Nama Orang tua/Wali <span style="color: red;">*</span></label>
                                <input required type="text" name="nama_wali" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Nomor Whatsapp Orang tua/Wali <span style="color: red;">*</span></label>
                                <input required type="text" name="wa_wali" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs font-bold text-gray-500 uppercase">Sudah mengisi skrining kesehatan mental<span style="color: red;">*</span></label>
                                <select name="skrining_kesehatan_mental" class="mt-1 border-none bg-gray-50 rounded-lg p-2 font-semibold text-gray-800">
                                    <option value="Belum" selected>Belum</option>
                                    <option value="Sudah">Sudah</option>
                                </select>
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
                            <h4 class="font-bold text-blue-900 border-b pb-1 text-sm uppercase tracking-wider">II. Pemeriksaan Fisik</h4>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-700 uppercase">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
                                    <input type="number" id="tinggi_badan" name="tinggi_badan" class="mt-1 border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: 173" required>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-xs font-bold text-gray-700 uppercase">Berat Badan (kg) <span class="text-red-500">*</span>label>
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

                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wide mb-1">
                            Riwayat kesehatan fisik (dari kecil sampai dewasa) <span class="text-red-500">*</span>
                        </label>
                        <!-- Keterangan tambahan -->
                        <p class="text-xs font-normal text-gray-500 italic mb-4">Jika Iya, Dicentang</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors md:col-span-2">
                                <div class="flex items-center h-5">
                                    <input id="riwayat_tidak_ada" name="riwayat_kesehatan_fisik" type="checkbox" value="Tidak ada" 
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                        onchange="toggleRiwayatNone(this)">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="riwayat_tidak_ada" class="font-bold text-gray-800">Tidak ada</label>
                                </div>
                            </div>

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

                            @foreach($riwayatList as $index => $riwayat)
                                <div class="flex items-start p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors checkbox-item">
                                    <div class="flex items-center h-5">
                                        <input id="riwayat_{{ $index }}" name="riwayat_kesehatan[]" type="checkbox" value="{{ $riwayat }}" 
                                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="riwayat_{{ $index }}" class="font-medium text-gray-700">{{ $riwayat }}</label>
                                    </div>
                                </div>
                            @endforeach

                            <div class="md:col-span-2 p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <input id="riwayat_other_checkbox" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" onchange="toggleOtherInput(this)">
                                    <label for="riwayat_other_checkbox" class="ml-3 text-sm font-medium text-gray-700">Other / Lainnya:</label>
                                </div>
                                <input type="text" id="riwayat_other_text" name="riwayat_kesehatan_other" placeholder="Sebutkan riwayat kesehatan lainnya jika ada..." 
                                    class="w-full mt-1 p-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all opacity-50" disabled>
                            </div>
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

        // Menaruh data fakultas & prodi dari controller ke dalam objek JavaScript (JSON)
        const masterData = {!! json_encode($faculties) !!};

        function updateProdi() {
            const fakultasSelect = document.getElementById('select-fakultas');
            const prodiSelect = document.getElementById('select-prodi');
            const selectedFacultyId = fakultasSelect.value;

            // Reset dropdown prodi
            prodiSelect.innerHTML = '';

            if (selectedFacultyId) {
                // Cari data fakultas yang sesuai dari objek masterData
                const activeFaculty = masterData.find(f => f.id == selectedFacultyId);

                if (activeFaculty && activeFaculty.program_studis.length > 0) {
                    prodiSelect.disabled = false;

                    // Tambahkan opsi default prodi
                    let defaultOpt = document.createElement('option');
                    defaultOpt.value = "";
                    defaultOpt.text = "-- Pilih Program Studi --";
                    prodiSelect.appendChild(defaultOpt);

                    // Looping program studi berdasarkan fakultas yang dipilih
                    activeFaculty.program_studis.forEach(function(prodi) {
                        let opt = document.createElement('option');
                        // Menyusun teks prodi dengan format tingkatannya (Contoh: "S1 Teknik Informatika")
                        const fullProdiName = `${prodi.level} ${prodi.name}`;
                        
                        opt.value = fullProdiName; // Bisa diganti prodi.id jika di backend butuh ID prodi-nya saja
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

        // Fungsi logika jika memilih "Tidak ada", maka opsi penyakit lain otomatis tidak aktif/tercentang
    function toggleRiwayatNone(src) {
        const checkboxes = document.querySelectorAll('.checkbox-item input[type="checkbox"]');
        const otherCheckbox = document.getElementById('riwayat_other_checkbox');
        const otherText = document.getElementById('riwayat_other_text');

        if (src.checked) {
            checkboxes.forEach(cb => {
                cb.checked = false;
                cb.disabled = true;
            });
            otherCheckbox.checked = false;
            otherCheckbox.disabled = true;
            otherText.value = '';
            otherText.disabled = true;
            otherText.classList.add('opacity-50');
        } else {
            checkboxes.forEach(cb => cb.disabled = false);
            otherCheckbox.disabled = false;
        }
    }

    // Fungsi logika mengaktifkan input teks teks jika checkbox "Other" dicentang
    function toggleOtherInput(src) {
        const otherText = document.getElementById('riwayat_other_text');
        if (src.checked) {
            otherText.disabled = false;
            otherText.classList.remove('opacity-50');
            otherText.focus();
        } else {
            otherText.disabled = true;
            otherText.value = '';
            otherText.classList.add('opacity-50');
        }
    }

    // Otomatisasi perhitungan usia dari field Tempat, Tanggal Lahir
    const tempatTanggalLahirInput = document.getElementById('tempat_tanggal_lahir');
    const usiaInput = document.getElementById('usia');

    tempatTanggalLahirInput.addEventListener('input', function() {
        const inputVal = this.value;
        
        // Memisahkan tempat dan tanggal berdasarkan tanda koma
        const parts = inputVal.split(',');
        
        if (parts.length > 1) {
            let dateStr = parts[parts.length - 1].trim(); 
            
            // Mapping nama bulan Indonesia ke Inggris agar bisa diparse oleh JS Date
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
                
                // Kurangi 1 tahun jika bulan/hari ini sebelum bulan/hari kelahiran di tahun ini
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
