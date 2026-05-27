<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Akun') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
                Tambah Akun Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form Search dan Filter -->
            <div class="mb-4 bg-white p-4 shadow-sm sm:rounded-lg">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:w-1/3">
                    <select name="role" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full sm:w-1/4">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="perawat" {{ request('role') == 'perawat' ? 'selected' : '' }}>Perawat</option>
                        <option value="dokter" {{ request('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 text-sm font-medium">Filter</button>
                    @if(request()->hasAny(['search', 'role']))
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 text-sm font-medium flex items-center justify-center">Reset</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    @php
            // Hapus fungsi sortUrl(), sisakan icon saja karena fungsi icon aman.
            function sortIcon($field) {
                if (request('sort') !== $field) return '';
                return request('direction') === 'asc' ? '↑' : '↓';
            }
        @endphp

        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b-2 py-3 px-4 font-semibold text-sm">
                        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('sort') === 'name' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-indigo-600">
                            Nama {{ sortIcon('name') }}
                        </a>
                    </th>
                    <th class="border-b-2 py-3 px-4 font-semibold text-sm">
                        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => request('sort') === 'email' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-indigo-600">
                            Email {{ sortIcon('email') }}
                        </a>
                    </th>
                    <th class="border-b-2 py-3 px-4 font-semibold text-sm">
                        <a href="{{ route('admin.users.index', array_merge(request()->query(), ['sort' => 'role', 'direction' => request('sort') === 'role' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-indigo-600">
                            Role {{ sortIcon('role') }}
                        </a>
                    </th>
                    <th class="border-b-2 py-3 px-4 font-semibold text-sm text-center">Aksi</th>
                </tr>
            </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="border-b py-3 px-4 text-sm">{{ $user->name }}</td>
                                    <td class="border-b py-3 px-4 text-sm">{{ $user->email }}</td>
                                    <td class="border-b py-3 px-4 text-sm">
                                        <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded-full text-xs uppercase">{{ $user->role }}</span>
                                    </td>
                                    <td class="border-b py-3 px-4 text-sm text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500 text-sm">
                                        Belum ada data akun.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="p-6 border-t border-gray-200">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
