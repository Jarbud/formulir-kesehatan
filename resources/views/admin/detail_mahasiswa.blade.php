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
                    <div class="w-full overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                        <table id="riwayatTable" class="w-full text-left border-collapse min-w-[1000px]"> {{-- Berikan minimal lebar statis agar tidak penyok --}}
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-4 w-[15%]">Tanggal</th>
                                    <th class="px-6 py-4 w-[12%]">NIM</th>
                                    <th class="px-6 py-4 w-[15%]">Bukti Pembayaran</th>
                                    <th class="px-6 py-4 w-[13%]">Status Proses</th>
                                    <th class="px-6 py-4 w-[20%]">Tenaga Kesehatan</th> {{-- Dipersingkat judulnya agar tidak memakan space --}}
                                    <th class="px-6 py-4 w-[15%]">Dokter</th>
                                    <th class="px-6 py-4 text-center w-[10%]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($riwayats as $riwayat)
                                    <tr class="hover:bg-gray-50/70 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                                            {{ $riwayat->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                                            {{ $riwayat->nim }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                            @if($riwayat->bukti_pembayaran)
                                                <a href="{{ asset('storage/' . $riwayat->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline inline-flex items-center gap-1">
                                                    Lihat File Bukti
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 uppercase tracking-wide font-semibold text-xs">
                                            {{ $riwayat->status_proses }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 font-medium max-w-[200px] truncate" title="{{ $riwayat->id_perawat_acc ? $riwayat->perawat->name : '' }}">
                                            @if($riwayat->id_perawat_acc)
                                                {{ $riwayat->perawat->name }}
                                            @else
                                                <span class="text-gray-400 italic font-normal">Belum Diperiksa</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 font-medium max-w-[150px] truncate" title="{{ $riwayat->id_dokter_acc ? $riwayat->dokter->name : '' }}">
                                            @if($riwayat->id_dokter_acc)
                                                {{ $riwayat->dokter->name }}
                                            @else
                                                <span class="text-gray-400 italic font-normal">Belum Diperiksa</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{-- Menggunakan flex row agar tombol berjejer rapi ke samping, bukan numpuk vertikal --}}
                                            <div class="flex flex-col items-center justify-center gap-2 whitespace-nowrap">
                                                <a href="{{ route('admin.cetak.formulir', $riwayat->id) }}" 
                                                target="_blank" 
                                                class="w-full justify-center inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 border border-indigo-200 rounded-md text-xs font-bold transition">
                                                    Lihat PDF
                                                </a>
                                                <a href="{{ secure_url(route('admin.export.excel', $riwayat->id)) }}" 
                                                class="w-full justify-center inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-100 border border-green-200 rounded-md text-xs font-bold transition">
                                                    Export Excel
                                                </a>
                                                <button type="button" onclick="openEditModal('modal-edit-{{ $riwayat->id }}')" 
                                                class="w-full justify-center inline-flex items-center px-3 py-1.5 bg-yellow-50 text-yellow-700 hover:bg-yellow-100 border border-yellow-200 rounded-md text-xs font-bold transition">
                                                    Edit
                                                </button>
                                                @if($riwayat->status_proses == 'admin')
                                                <button type="button" onclick="openModal('modal-ttd-{{ $riwayat->id }}')" 
                                                class="w-full justify-center inline-flex items-center px-3 py-1.5 bg-purple-50 text-purple-700 hover:bg-purple-100 border border-purple-200 rounded-md text-xs font-bold transition">
                                                    TTD
                                                </button>
                                                @endif
                                            </div>
                                        </td> 
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Kumpulan Modal TTD dan Edit -->
                    @foreach($riwayats as $riwayat)
                        @if($riwayat->status_proses !== 'selesai')
                        <div id="modal-ttd-{{ $riwayat->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeModal('modal-ttd-{{ $riwayat->id }}')"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <form action="{{ route('admin.pemeriksaan.ttd', $riwayat->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Konfirmasi Tanda Tangan</h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menandatangani dan menyelesaikan dokumen pemeriksaan ini?</p>
                                            </div>
                                        </div>
                                        <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-purple-600 border border-transparent rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">Iya, Tandatangani</button>
                                            <button type="button" onclick="closeModal('modal-ttd-{{ $riwayat->id }}')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Tidak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Modal Edit -->
                        <div id="modal-edit-{{ $riwayat->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeModal('modal-edit-{{ $riwayat->id }}')"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                                    <form action="{{ route('admin.pemeriksaan.update', $riwayat->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                                            <h3 class="text-lg font-bold text-gray-900" id="modal-title">Edit Data Pemeriksaan</h3>
                                            <button type="button" onclick="closeModal('modal-edit-{{ $riwayat->id }}')" class="text-gray-400 hover:text-gray-500">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <div class="px-6 py-4 max-h-[65vh] overflow-y-auto space-y-6 text-left">
                                            <!-- I. IDENTITAS MAHASISWA -->
                                            <div>
                                                <h4 class="font-bold text-blue-900 border-b pb-1 text-xs uppercase tracking-wider mb-4">I. Identitas Mahasiswa</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div class="md:col-span-2">
                                                        <label for="name_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Nama Lengkap</label>
                                                        <input type="text" name="name" id="name_{{ $riwayat->id }}" value="{{ $riwayat->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="nik_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">NIK</label>
                                                        <input type="text" name="nik" id="nik_{{ $riwayat->id }}" value="{{ $riwayat->nik }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="nim_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">NIM</label>
                                                        <input type="text" name="nim" id="nim_{{ $riwayat->id }}" value="{{ $riwayat->nim }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="jenis_kelamin_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Jenis Kelamin</label>
                                                        <select name="jenis_kelamin" id="jenis_kelamin_{{ $riwayat->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                            <option value="laki-laki" {{ $riwayat->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                            <option value="perempuan" {{ $riwayat->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="usia_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Usia</label>
                                                        <input type="number" name="usia" id="usia_{{ $riwayat->id }}" value="{{ $riwayat->usia }}" readonly class="mt-1 block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm text-sm font-bold text-gray-700 cursor-not-allowed">
                                                    </div>
                                                    <div>
                                                        <label for="fakultas_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Fakultas</label>
                                                        <input type="text" name="fakultas" id="fakultas_{{ $riwayat->id }}" value="{{ $riwayat->fakultas }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="prodi_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Prodi</label>
                                                        <input type="text" name="prodi" id="prodi_{{ $riwayat->id }}" value="{{ $riwayat->prodi }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label for="tempat_tanggal_lahir_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Tempat, Tanggal Lahir</label>
                                                        <input type="text" name="tempat_tanggal_lahir" id="tempat_tanggal_lahir_{{ $riwayat->id }}" value="{{ $riwayat->tempat_tanggal_lahir }}" oninput="hitungUsiaAdmin('{{ $riwayat->id }}')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Malang, 20 April 2000">
                                                    </div>
                                                    <div>
                                                        <label for="alamat_asal_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Alamat Asal</label>
                                                        <textarea name="alamat_asal" id="alamat_asal_{{ $riwayat->id }}" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">{{ $riwayat->alamat_asal }}</textarea>
                                                    </div>
                                                    <div>
                                                        <label for="alamat_malang_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Alamat di Malang</label>
                                                        <textarea name="alamat_malang" id="alamat_malang_{{ $riwayat->id }}" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">{{ $riwayat->alamat_malang }}</textarea>
                                                    </div>
                                                    <div>
                                                        <label for="wa_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Nomor WA Mahasiswa</label>
                                                        <input type="text" name="wa" id="wa_{{ $riwayat->id }}" value="{{ $riwayat->wa }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="nama_wali_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Nama Orang Tua/Wali</label>
                                                        <input type="text" name="nama_wali" id="nama_wali_{{ $riwayat->id }}" value="{{ $riwayat->nama_wali }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="wa_wali_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Nomor WA Orang Tua/Wali</label>
                                                        <input type="text" name="wa_wali" id="wa_wali_{{ $riwayat->id }}" value="{{ $riwayat->wa_wali }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="skrining_kesehatan_mental_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Skrining Kesehatan Mental</label>
                                                        <select name="skrining_kesehatan_mental" id="skrining_kesehatan_mental_{{ $riwayat->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                            <option value="Belum" {{ $riwayat->skrining_kesehatan_mental == 'Belum' ? 'selected' : '' }}>Belum</option>
                                                            <option value="Sudah" {{ $riwayat->skrining_kesehatan_mental == 'Sudah' ? 'selected' : '' }}>Sudah</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="disabilitas_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Disabilitas</label>
                                                        <select name="disabilitas" id="disabilitas_{{ $riwayat->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                            <option value="Tidak Ada" {{ $riwayat->disabilitas == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                                            <option value="Ada" {{ $riwayat->disabilitas == 'Ada' ? 'selected' : '' }}>Ada</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- II. PEMERIKSAAN FISIK & MEDIS -->
                                            <div>
                                                <h4 class="font-bold text-blue-900 border-b pb-1 text-xs uppercase tracking-wider mb-4">II. Pemeriksaan Fisik & Medis</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="tinggi_badan_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Tinggi Badan (cm)</label>
                                                        <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan_{{ $riwayat->id }}" value="{{ $riwayat->tinggi_badan }}" oninput="hitungImtAdmin('{{ $riwayat->id }}')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="berat_badan_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Berat Badan (kg)</label>
                                                        <input type="number" step="0.1" name="berat_badan" id="berat_badan_{{ $riwayat->id }}" value="{{ $riwayat->berat_badan }}" oninput="hitungImtAdmin('{{ $riwayat->id }}')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="imt_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Nilai IMT</label>
                                                        <input type="text" name="imt" id="imt_{{ $riwayat->id }}" value="{{ $riwayat->imt }}" readonly class="mt-1 block w-full bg-gray-50 border-gray-300 rounded-md shadow-sm text-sm font-bold text-gray-700 cursor-not-allowed">
                                                    </div>
                                                    <div>
                                                        <label for="tekanan_darah_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Tekanan Darah (mmHg)</label>
                                                        <input type="text" name="tekanan_darah" id="tekanan_darah_{{ $riwayat->id }}" value="{{ $riwayat->tekanan_darah }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label for="ishihara_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Ishihara Test</label>
                                                        <select name="ishihara" id="ishihara_{{ $riwayat->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                            <option value="-" {{ $riwayat->ishihara == '-' ? 'selected' : '' }}>( - )</option>
                                                            <option value="+" {{ $riwayat->ishihara == '+' ? 'selected' : '' }}>( + )</option>
                                                            <option value="parsial" {{ $riwayat->ishihara == 'parsial' ? 'selected' : '' }}>Parsial</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="lingkar_perut_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Lingkar Perut (cm)</label>
                                                        <input type="number" step="0.1" name="lingkar_perut" id="lingkar_perut_{{ $riwayat->id }}" value="{{ $riwayat->lingkar_perut }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="gula_darah_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Gula Darah (mg/dL)</label>
                                                        <input type="number" step="0.1" name="gula_darah" id="gula_darah_{{ $riwayat->id }}" value="{{ $riwayat->gula_darah }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label for="visus_mata_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Visus Mata</label>
                                                        <select name="visus_mata" id="visus_mata_{{ $riwayat->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                            <option value="Normal" {{ $riwayat->visus_mata == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                            <option value="Gangguan" {{ $riwayat->visus_mata == 'Gangguan' ? 'selected' : '' }}>Gangguan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- III. RIWAYAT & KELUHAN -->
                                            <div>
                                                <h4 class="font-bold text-blue-900 border-b pb-1 text-xs uppercase tracking-wider mb-4">III. Riwayat & Keluhan</h4>
                                                <div class="space-y-4">
                                                    <div>
                                                        <label for="riwayat_sakit_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Riwayat Sakit</label>
                                                        <input type="text" name="riwayat_sakit" id="riwayat_sakit_{{ $riwayat->id }}" value="{{ $riwayat->riwayat_sakit }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                    </div>
                                                    <div>
                                                        <label for="riwayat_kesehatan_fisik_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Riwayat Kesehatan Fisik</label>
                                                        <textarea name="riwayat_kesehatan_fisik" id="riwayat_kesehatan_fisik_{{ $riwayat->id }}" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">{{ $riwayat->riwayat_kesehatan_fisik }}</textarea>
                                                    </div>
                                                    <div>
                                                        <label for="keluhan_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Keluhan Saat Ini</label>
                                                        <textarea name="keluhan" id="keluhan_{{ $riwayat->id }}" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">{{ $riwayat->keluhan }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- IV. KESIMPULAN DOKTER -->
                                            <div>
                                                <h4 class="font-bold text-blue-900 border-b pb-1 text-xs uppercase tracking-wider mb-4">IV. Kesimpulan & Rekomendasi</h4>
                                                <div class="space-y-4">
                                                    <div>
                                                        <label for="kesimpulan_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Kesimpulan</label>
                                                        <select name="kesimpulan" id="kesimpulan_{{ $riwayat->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                                                            <option value="Layak" {{ $riwayat->kesimpulan == 'Layak' ? 'selected' : '' }}>Layak</option>
                                                            <option value="Layak dengan Syarat" {{ $riwayat->kesimpulan == 'Layak dengan Syarat' ? 'selected' : '' }}>Layak dengan Syarat</option>
                                                            <option value="Tidak Layak Mengikuti PKKMB" {{ $riwayat->kesimpulan == 'Tidak Layak Mengikuti PKKMB' ? 'selected' : '' }}>Tidak Layak Mengikuti PKKMB</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="rekomendasi_{{ $riwayat->id }}" class="block text-xs font-semibold text-gray-500 uppercase">Rekomendasi</label>
                                                        <textarea name="rekomendasi" id="rekomendasi_{{ $riwayat->id }}" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">{{ $riwayat->rekomendasi }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 sm:flex sm:flex-row-reverse gap-2">
                                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm">Simpan</button>
                                            <button type="button" onclick="closeModal('modal-edit-{{ $riwayat->id }}')" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Batal</button>
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

            // Memanggil hitungImtAdmin dan hitungUsiaAdmin saat modal dibuka agar data terhitung sejak awal
            function openEditModal(id) {
                openModal(id);
                const rawId = id.replace('modal-edit-', '');
                hitungImtAdmin(rawId);
                hitungUsiaAdmin(rawId);
            }

            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
            }

            function hitungImtAdmin(id) {
                const tinggiInput = document.getElementById('tinggi_badan_' + id);
                const beratInput = document.getElementById('berat_badan_' + id);
                const imtInput = document.getElementById('imt_' + id);
                
                if (tinggiInput && beratInput && imtInput) {
                    const tinggi = parseFloat(tinggiInput.value) / 100; // ubah ke meter
                    const berat = parseFloat(beratInput.value);

                    if (tinggi > 0 && berat > 0) {
                        const imt = (berat / (tinggi * tinggi)).toFixed(2);
                        imtInput.value = imt;
                    } else {
                        imtInput.value = '';
                    }
                }
            }

            function hitungUsiaAdmin(id) {
                const ttlInput = document.getElementById('tempat_tanggal_lahir_' + id);
                const usiaInput = document.getElementById('usia_' + id);
                
                if (ttlInput && usiaInput) {
                    const inputVal = ttlInput.value;
                    const parts = inputVal.split(',');
                    
                    if (parts.length > 1) {
                        let dateStr = parts[parts.length - 1].trim(); 
                        
                        const bulanIdEn = {
                            'januari': 'January', 'februari': 'February', 'maret': 'March', 'april': 'April',
                            'mei': 'May', 'juni': 'June', 'juli': 'July', 'agustus': 'August',
                            'september': 'September', 'oktober': 'October', 'november': 'November', 'desember': 'December'
                        };

                        let engDateStr = dateStr.toLowerCase();
                        for (const [idn, eng] of Object.entries(bulanIdEn)) {
                            engDateStr = engDateStr.replace(idn, eng.toLowerCase());
                        }

                        const dob = new Date(engDateStr);
                        
                        if (!isNaN(dob.getTime())) {
                            const today = new Date();
                            let age = today.getFullYear() - dob.getFullYear();
                            const m = today.getMonth() - dob.getMonth();
                            
                            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
                                age--;
                            }
                            
                            if (age >= 0 && age < 150) { 
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
                }
            }
        </script>
    </div>
</x-app-layout>
