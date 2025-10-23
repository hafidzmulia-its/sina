
<x-app-layout>
    <style>
        .book-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .book-cover {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        .filter-button {
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            border: 2px solid #e5e7eb;
            background: white;
            color: #6b7280;
            font-weight: 500;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .filter-button.active {
            background: #0d9488;
            border-color: #0d9488;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
        }

        .filter-button:hover {
            border-color: #0d9488;
            color: #0d9488;
            transform: translateY(-2px);
        }

        .filter-button.active:hover {
            background: #0f766e;
            border-color: #0f766e;
            color: white;
        }

        .search-results-info {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .clear-search {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .clear-search:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }
    </style>
    
    <main class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 font-comfortaa mb-4">
                    @if(request('search'))
                        Hasil Pencarian "{{ request('search') }}"
                    @elseif(request('jenis'))
                        Koleksi {{ request('jenis') }}
                    @else
                        Semua Koleksi Buku
                    @endif
                </h1>

                <!-- Search Results Info -->
                @if(request('search'))
                <div class="search-results-info">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold mb-1">
                                Ditemukan {{ $bukus->total() }} buku untuk "{{ request('search') }}"
                            </h3>
                            @if(request('jenis'))
                                <p class="text-sm opacity-90">dalam kategori {{ request('jenis') }}</p>
                            @endif
                        </div>
                        <a href="{{ route('buku.index', request()->only('jenis')) }}" class="clear-search">
                            ✕ Hapus Pencarian
                        </a>
                    </div>
                </div>
                @endif

                <!-- Type Filters -->
                <div class="flex flex-wrap gap-3 mb-6">
                    <a href="{{ route('buku.index', request()->only('search')) }}" 
                       class="filter-button {{ !request('jenis') ? 'active' : '' }}">
                        Semua Kategori
                    </a>
                    @foreach($jenisOptions as $jenis)
                    <a href="{{ route('buku.index', array_merge(request()->only('search'), ['jenis' => $jenis])) }}" 
                       class="filter-button {{ request('jenis') === $jenis ? 'active' : '' }}">
                        {{ $jenis }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Books Grid -->
            @if($bukus->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-8">
                @foreach($bukus as $buku)
                <div class="book-card" onclick="viewBook({{ $buku->id }})">
                    <img 
                        src="{{ $buku->cover ? asset($buku->cover) : asset('images/default-book-cover.png') }}" 
                        alt="{{ $buku->judul }}"
                        class="book-cover"
                    />
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2">
                            {{ $buku->judul }}
                        </h3>
                        <p class="text-xs text-teal-600 font-medium">{{ $buku->jenis }}</p>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                            {{ Str::limit($buku->sinopsis, 60) }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $bukus->appends(request()->query())->links() }}
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada buku ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request('search'))
                        Coba kata kunci lain atau hapus filter pencarian.
                    @elseif(request('jenis'))
                        Belum ada buku dalam kategori {{ request('jenis') }}.
                    @else
                        Belum ada buku dalam koleksi.
                    @endif
                </p>
                @if(request('search') || request('jenis'))
                <div class="mt-4">
                    <a href="{{ route('buku.index') }}" class="text-teal-600 hover:text-teal-700 font-medium">
                        Lihat semua buku →
                    </a>
                </div>
                @endif
            </div>
            @endif
        </div>
    </main>

    <script>
        function viewBook(bookId) {
            window.location.href = `/buku/${bookId}`;
        }
    </script>
</x-app-layout>