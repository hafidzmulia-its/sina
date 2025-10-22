<x-app-layout>
    <!-- Add CSRF meta tag -->
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

    <div class="py-4 px-6 bg-white border-b border-gray-200">
        <div class="flex justify-between max-w-7xl mx-auto items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Katalog Buku') }}
            </h2>
            <a href="{{ route('managementbuku.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="createBookBtn">
                Tambah Buku Baru
            </a>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Session Expired Warning -->
                    <div id="sessionWarning" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 hidden">
                        <strong>Peringatan:</strong> Sesi Anda mungkin telah berakhir. Silakan refresh halaman sebelum melanjutkan.
                        <button onclick="location.reload()" class="ml-2 bg-yellow-500 text-white px-2 py-1 rounded text-sm">
                            Refresh
                        </button>
                    </div>
                    
                    <!-- Search and Filter -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('managementbuku.index') }}" class="flex flex-wrap gap-4">
                            <div class="flex-1 min-w-64">
                                <input type="text" name="search" value="{{ $search ?? '' }}" 
                                       placeholder="Cari berdasarkan judul atau sinopsis..." 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <select name="jenis" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Semua Jenis</option>
                                    @if(isset($jenisOptions))
                                        @foreach($jenisOptions as $option)
                                            <option value="{{ $option }}" {{ ($jenis ?? '') == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Filter
                                </button>
                                <a href="{{ route('managementbuku.index') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">
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

                    <!-- Error Message -->
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Books Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sinopsis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($bukus))
                                    @forelse($bukus as $buku)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($buku->cover)
                                                    <img src="{{ asset($buku->cover) }}" alt="{{ $buku->judul }}" class="h-16 w-12 object-cover rounded">
                                                @else
                                                    <div class="h-16 w-12 bg-gray-200 rounded flex items-center justify-center">
                                                        <span class="text-xs text-gray-500">No Image</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $buku->judul }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $buku->jenis }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ Str::limit($buku->sinopsis, 100) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('managementbuku.show', $buku) }}" class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                                    <a href="{{ route('managementbuku.edit', $buku) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                    <form method="POST" action="{{ route('managementbuku.destroy', $buku) }}" class="inline delete-form" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                Tidak ada buku ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            Data buku tidak tersedia.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if(isset($bukus))
                        <div class="mt-6">
                            {{ $bukus->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // CSRF Token refresh
        function refreshCSRFToken() {
            fetch('/csrf-token')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf_token);
                    // Update all forms with new token
                    document.querySelectorAll('form input[name="_token"]').forEach(input => {
                        input.value = data.csrf_token;
                    });
                })
                .catch(error => {
                    console.error('Error refreshing CSRF token:', error);
                    document.getElementById('sessionWarning').classList.remove('hidden');
                });
        }

        // Check session status periodically
        setInterval(function() {
            fetch('/session-check')
                .then(response => {
                    if (response.status === 419) {
                        document.getElementById('sessionWarning').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.log('Session check failed:', error);
                });
        }, 300000); // Check every 5 minutes

        // Handle delete forms with fresh CSRF token
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Refresh CSRF token before submitting
                fetch('/csrf-token')
                    .then(response => response.json())
                    .then(data => {
                        // Update form token
                        const tokenInput = form.querySelector('input[name="_token"]');
                        if (tokenInput) {
                            tokenInput.value = data.csrf_token;
                        }
                        // Submit form
                        form.submit();
                    })
                    .catch(error => {
                        console.error('Error refreshing token:', error);
                        alert('Terjadi kesalahan. Silakan refresh halaman dan coba lagi.');
                    });
            });
        });

        // Handle create button click
        document.getElementById('createBookBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Check session before navigating
            fetch('/session-check')
                .then(response => {
                    if (response.ok) {
                        window.location.href = this.href;
                    } else {
                        document.getElementById('sessionWarning').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Session check failed:', error);
                    // Navigate anyway
                    window.location.href = this.href;
                });
        });
    </script>
</x-app-layout>