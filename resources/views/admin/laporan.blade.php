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

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <!-- FORM FILTER -->
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-200 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-50 to-emerald-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-800">Filter Data Laporan</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tentukan kriteria data yang ingin diunduh</p>
                </div>

                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.laporan.index') }}" method="GET">
                        <div class="mb-6">
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </span>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Filter Akademik</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="fakultas" class="block text-xs font-semibold text-slate-700 mb-2">Fakultas (Opsional)</label>
                                    <select id="fakultas" name="fakultas" class="block w-full border-slate-200 rounded-xl shadow-sm bg-slate-50/50 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm transition py-2.5">
                                        <option value="">Semua Fakultas</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->name }}" {{ request('fakultas') == $faculty->name ? 'selected' : '' }}>{{ $faculty->name }}</option>
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
                                    <option value="semua" {{ request('filter_waktu', 'semua') == 'semua' ? 'selected' : '' }}>Semua Waktu</option>
                                    <option value="harian" {{ request('filter_waktu') == 'harian' ? 'selected' : '' }}>Harian (Pilih Tanggal)</option>
                                    <option value="bulanan" {{ request('filter_waktu') == 'bulanan' ? 'selected' : '' }}>Bulanan (Pilih Bulan & Tahun)</option>
                                    <option value="tahunan" {{ request('filter_waktu') == 'tahunan' ? 'selected' : '' }}>Tahunan (Pilih Tahun)</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                <div id="input_tanggal" class="{{ request('filter_waktu') != 'harian' ? 'hidden' : '' }} transition-all duration-300">
                                    <label for="tanggal" class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2">
                                </div>

                                <div id="input_bulan" class="{{ request('filter_waktu') != 'bulanan' ? 'hidden' : '' }} transition-all duration-300">
                                    <label for="bulan" class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Bulan</label>
                                    <select id="bulan" name="bulan" class="block w-full border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2">
                                        <option value="">Pilih Bulan</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ sprintf('%02d', $i) }}" {{ request('bulan') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div id="input_tahun" class="{{ !in_array(request('filter_waktu'), ['bulanan', 'tahunan']) ? 'hidden' : '' }} transition-all duration-300">
                                    <label for="tahun" class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Tahun</label>
                                    <input type="number" id="tahun" name="tahun" min="2020" max="{{ date('Y') }}" value="{{ request('tahun', date('Y')) }}" class="block w-full border-slate-200 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm py-2">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 border-t pt-6 border-slate-100">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 font-bold shadow-md shadow-indigo-600/10 hover:shadow-lg hover:shadow-indigo-600/20 transition-all duration-200 active:scale-[0.98]">
                                <svg class="w-5 h-5 mr-2 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Tampilkan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RINGKASAN + AKSI (muncul jika sudah ada filter / data) -->
            @if(request()->has('fakultas') || request()->has('prodi') || request()->has('filter_waktu'))

            <!-- RINGKASAN -->
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-200 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-800">Ringkasan Data</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <div class="text-2xl font-bold text-slate-800">{{ $total }}</div>
                            <div class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-wider">Total Data</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-xl border border-green-200">
                            <div class="text-2xl font-bold text-green-700">{{ $sudah_export }}</div>
                            <div class="text-xs font-semibold text-green-600 mt-1 uppercase tracking-wider">Sudah Diexport</div>
                            @if($export_terakhir)
                                <div class="text-[10px] text-green-500 mt-1">Terakhir: {{ \Carbon\Carbon::parse($export_terakhir)->locale('id')->isoFormat('D MMM Y, HH:mm') }}</div>
                            @endif
                        </div>
                        <div class="text-center p-4 bg-amber-50 rounded-xl border border-amber-200">
                            <div class="text-2xl font-bold text-amber-700">{{ $belum_export }}</div>
                            <div class="text-xs font-semibold text-amber-600 mt-1 uppercase tracking-wider">Belum Diexport</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AKSI EXPORT -->
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-200 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-slate-200">
                    <h3 class="text-sm font-bold text-slate-800">Aksi Export</h3>
                </div>
                <div class="p-6">

                    <!-- Export PDF -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Export PDF per Batch</h4>
                        @if($belum_export > 0)
                            <form action="{{ route('admin.laporan.export_pdf') }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                @csrf
                                {{-- Pass filter ke hidden inputs --}}
                                <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
                                <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                                <input type="hidden" name="filter_waktu" value="{{ request('filter_waktu') }}">
                                <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                                <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                <input type="hidden" name="tahun" value="{{ request('tahun') }}">

                                <div class="flex items-center gap-2">
                                    <label for="batch" class="text-xs font-semibold text-slate-600">Jumlah per batch:</label>
                                    <select name="batch" id="batch" class="border-slate-200 rounded-lg text-sm py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                        <option value="25">25 data</option>
                                        <option value="50">50 data</option>
                                        <option value="75">75 data</option>
                                        <option value="100">100 data</option>
                                    </select>
                                </div>

                                <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 font-bold shadow-md shadow-blue-600/10 hover:shadow-lg hover:shadow-blue-600/20 transition-all duration-200 active:scale-[0.98]">
                                    <svg class="w-4 h-4 mr-2 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Export PDF ({{ $belum_export }} data belum diexport)
                                </button>
                            </form>
                        @else
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-700">
                                Semua data sudah diexport. Klik "Reset Status Export" jika ingin mengekspor ulang.
                            </div>
                        @endif
                    </div>

                    <!-- Export CSV (tetap ada) -->
                    <div class="mb-6 border-t border-slate-100 pt-6">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Export CSV / Excel</h4>
                        <form action="{{ route('admin.laporan.export') }}" method="POST">
                            @csrf
                            <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
                            <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                            <input type="hidden" name="filter_waktu" value="{{ request('filter_waktu') }}">
                            <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                            <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                            <input type="hidden" name="tahun" value="{{ request('tahun') }}">

                            <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl hover:from-emerald-700 hover:to-teal-700 font-bold shadow-md shadow-emerald-600/10 hover:shadow-lg hover:shadow-emerald-600/20 transition-all duration-200 active:scale-[0.98]">
                                <svg class="w-4 h-4 mr-2 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Unduh Laporan Excel (CSV)
                            </button>
                        </form>
                    </div>

                    <!-- Reset Status Export -->
                    <div class="border-t border-slate-100 pt-6">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Reset Status Export</h4>
                        @if($sudah_export > 0)
                            <form action="{{ route('admin.laporan.reset_export') }}" method="POST" onsubmit="return confirm('Yakin ingin mereset status export? Semua data akan bisa diexport ulang.')">
                                @csrf
                                <input type="hidden" name="fakultas" value="{{ request('fakultas') }}">
                                <input type="hidden" name="prodi" value="{{ request('prodi') }}">
                                <input type="hidden" name="filter_waktu" value="{{ request('filter_waktu') }}">
                                <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                                <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                <input type="hidden" name="tahun" value="{{ request('tahun') }}">

                                <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-white border-2 border-red-300 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-400 font-bold transition-all duration-200 active:scale-[0.98]">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Reset Status Export ({{ $sudah_export }} data)
                                </button>
                            </form>
                        @else
                            <div class="text-sm text-slate-400 italic">Belum ada data yang diexport.</div>
                        @endif
                    </div>

                </div>
            </div>

            @endif
            <!-- END RINGKASAN + AKSI -->

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
