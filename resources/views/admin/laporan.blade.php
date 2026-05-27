<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Pemeriksaan Kesehatan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-200 overflow-hidden">
                
                <div class="bg-gradient-to-r from-indigo-50 to-emerald-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Filter Ekspor Data</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Tentukan kriteria data mahasiswa yang ingin diunduh ke Excel</p>
                    </div>
                    <span class="px-2.5 py-1 bg-white border border-slate-200 text-[10px] font-bold text-indigo-600 rounded-full shadow-sm uppercase tracking-wider">CSV/XLSX Format</span>
                </div>

                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.laporan.export') }}" method="POST">
                        @csrf
                        
                        <div class="mb-8">
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </span>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Filter Filter Akademik</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="fakultas" class="block text-xs font-semibold text-slate-700 mb-2">Fakultas (Opsional)</label>
                                    <select id="fakultas" name="fakultas" class="block w-full border-slate-200 rounded-xl shadow-sm bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm transition py-2.5">
                                        <option value="">Semua Fakultas</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->name }}" data-id="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="prodi" class="block text-xs font-semibold text-slate-700 mb-2">Program Studi (Opsional)</label>
                                    <select id="prodi" name="prodi" class="block w-full border-slate-200 rounded-xl shadow-sm bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm transition py-2.5">
                                        <option value="">Semua Program Studi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6 border-t border-slate-100 pt-6">
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </span>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Filter Rentang Waktu</h4>
                            </div>

                            <div class="mb-6">
                                <label for="filter_waktu" class="block text-xs font-semibold text-slate-700 mb-2">Periode Waktu Laporan</label>
                                <select id="filter_waktu" name="filter_waktu" class="block w-full md:w-1/2 border-slate-200 rounded-xl shadow-sm bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm transition py-2.5" onchange="toggleWaktuInputs()">
                                    <option value="semua">Semua Waktu</option>
                                    <option value="harian">Harian (Pilih Tanggal)</option>
                                    <option value="bulanan">Bulanan (Pilih Bulan & Tahun)</option>
                                    <option value="tahunan">Tahunan (Pilih Tahun)</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                <div id="input_tanggal" class="hidden transition-all duration-300">
                                    <label for="tanggal" class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" class="block w-full border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2">
                                </div>

                                <div id="input_bulan" class="hidden transition-all duration-300">
                                    <label for="bulan" class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Bulan</label>
                                    <select id="bulan" name="bulan" class="block w-full border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2">
                                        <option value="">Pilih Bulan</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ sprintf('%02d', $i) }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div id="input_tahun" class="hidden transition-all duration-300">
                                    <label for="tahun" class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Tahun</label>
                                    <input type="number" id="tahun" name="tahun" min="2020" max="{{ date('Y') }}" value="{{ date('Y') }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-10 border-t pt-6 border-slate-100">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl hover:from-emerald-700 hover:to-teal-700 font-bold shadow-md shadow-emerald-600/10 hover:shadow-lg hover:shadow-emerald-600/20 transition-all duration-200 active:scale-[0.98]">
                                <svg class="w-5 h-5 mr-2.5 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Unduh Laporan Excel (CSV)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const faculties = @json($faculties);
        
        document.getElementById('fakultas').addEventListener('change', function() {
            const selectedFacultyName = this.value;
            const prodiSelect = document.getElementById('prodi');
            
            prodiSelect.innerHTML = '<option value="">Semua Program Studi</option>';
            
            if (selectedFacultyName) {
                const faculty = faculties.find(f => f.name === selectedFacultyName);
                const prodis = faculty ? (faculty.program_studis || faculty.programStudis) : null;
                
                if (prodis) {
                    prodis.forEach(prodi => {
                        const option = document.createElement('option');
                        option.value = prodi.name;
                        option.textContent = prodi.name;
                        prodiSelect.appendChild(option);
                    });
                }
            }
        });

        function toggleWaktuInputs() {
            const filterWaktu = document.getElementById('filter_waktu').value;
            document.getElementById('input_tanggal').classList.toggle('hidden', filterWaktu !== 'harian');
            document.getElementById('input_bulan').classList.toggle('hidden', filterWaktu !== 'bulanan');
            document.getElementById('input_tahun').classList.toggle('hidden', filterWaktu !== 'bulanan' && filterWaktu !== 'tahunan');
        }
    </script>
</x-app-layout>