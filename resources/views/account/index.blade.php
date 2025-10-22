<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Akun') }}
            </h2>
            <a href="{{ route('account.create', ['type' => $type]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Akun Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Tab Navigation (Only for Super Admin) -->
                    @if(auth()->user()->isSuperAdmin())
                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <a href="{{ route('account.index', ['type' => 'admins']) }}" 
                                   class="py-2 px-1 border-b-2 font-medium text-sm {{ $type === 'admins' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Admin
                                    <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs">
                                        {{ \App\Models\User::whereIn('role', ['admin', 'superadmin'])->count() }}
                                    </span>
                                </a>
                                <a href="{{ route('account.index', ['type' => 'users']) }}" 
                                   class="py-2 px-1 border-b-2 font-medium text-sm {{ $type === 'users' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Pengguna
                                    <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs">
                                        {{ \App\Models\User::whereIn('role', ['orangtua', 'anak'])->count() }}
                                    </span>
                                </a>
                            </nav>
                        </div>
                    </div>
                    @endif

                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('account.index') }}" class="flex flex-wrap gap-4">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <div class="flex-1 min-w-64">
                                <input type="text" name="search" value="{{ $search }}" 
                                       placeholder="Cari berdasarkan nama, username, atau email..." 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <select name="role" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Semua Role</option>
                                    @if($type === 'admins' && auth()->user()->isSuperAdmin())
                                        <option value="superadmin" {{ $role == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                        <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    @else
                                        <option value="orangtua" {{ $role == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                                        <option value="anak" {{ $role == 'anak' ? 'selected' : '' }}>Anak</option>
                                    @endif
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Filter
                                </button>
                                <a href="{{ route('account.index', ['type' => $type]) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Accounts Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hubungan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($accounts as $account)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $account->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $account->username }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $account->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $account->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : 
                                                   ($account->role === 'admin' ? 'bg-blue-100 text-blue-800' : 
                                                   ($account->role === 'orangtua' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $account->role)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($account->role === 'orangtua' && $account->children->count() > 0)
                                                <div class="text-xs">
                                                    <strong>Anak:</strong><br>
                                                    @foreach($account->children as $child)
                                                        {{ $child->name }} ({{ $child->username }})
                                                        @if(!$loop->last)<br>@endif
                                                    @endforeach
                                                </div>
                                            @elseif($account->role === 'anak' && $account->parent)
                                                <div class="text-xs">
                                                    <strong>Orang Tua:</strong><br>
                                                    {{ $account->parent->name }} ({{ $account->parent->username }})
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('account.show', $account) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                                <a href="{{ route('account.edit', $account) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                @if($account->id !== auth()->id())
                                                <form method="POST" action="{{ route('account.destroy', $account) }}" class="inline" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada akun ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $accounts->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>