
<x-app-layout>
    <style>
        .book-card {
            background: white;
            /* keep visual card shape, but DO NOT clip child images so PNG rounded corners remain visible */
            border-radius: 16px;
            /* removed overflow: hidden so PNG transparent corners are preserved */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .book-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .book-cover {
            width: 100%;
            /* enforce the book cover intrinsic ratio of 488x724 -> approx 0.673
               Use aspect-ratio so height scales correctly while maintaining ratio */
            aspect-ratio: 488 / 724;
            object-fit: cover;
            /* do not inherit border-radius from the parent; keep image corners from the PNG itself */
            border-radius: 0;
            display: block;
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

        /* Pagination Styles */
        .per-page-btn {
            padding: 0.5rem 0.875rem;
            border-radius: 20px;
            border: 2px solid #e5e7eb;
            background: white;
            color: #6b7280;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            min-width: 45px;
            justify-content: center;
        }

        .per-page-btn.active {
            background: #0d9488;
            border-color: #0d9488;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
        }

        .per-page-btn:hover:not(.active) {
            border-color: #0d9488;
            color: #0d9488;
            transform: translateY(-1px);
        }

        .pagination-btn {
            padding: 0.75rem 1.25rem;
            border-radius: 25px;
            border: 2px solid #e5e7eb;
            background: white;
            color: #374151;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination-btn:hover:not(.disabled) {
            border-color: #0d9488;
            color: #0d9488;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15);
        }

        .pagination-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            color: #9ca3af;
            border-color: #e5e7eb;
        }

        .page-number {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            background: white;
            color: #374151;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.3s;
        }

        .page-number:hover:not(.active) {
            border-color: #0d9488;
            color: #0d9488;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15);
        }

        .page-number.active {
            background: #0d9488;
            border-color: #0d9488;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(13, 148, 136, 0.25);
        }

        .page-ellipsis {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: #9ca3af;
            font-weight: 500;
        }

        .page-jump-input {
            width: 60px;
            padding: 0.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            text-align: center;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .page-jump-input:focus {
            outline: none;
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
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

            <!-- Pagination Section -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <!-- Items Per Page Selector -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <div class="flex items-center space-x-3 mb-4 sm:mb-0">
                        <span class="text-sm text-gray-600 font-inter">Tampilkan:</span>
                        <div class="flex space-x-2">
                            @foreach([10, 20, 50] as $perPage)
                                <a href="{{ route('buku.index', array_merge(request()->query(), ['per_page' => $perPage, 'page' => 1])) }}" 
                                   class="per-page-btn {{ request('per_page', 10) == $perPage ? 'active' : '' }}">
                                    {{ $perPage }}
                                </a>
                            @endforeach
                            <a href="{{ route('buku.index', array_merge(request()->query(), ['per_page' => 'all', 'page' => 1])) }}" 
                               class="per-page-btn {{ request('per_page') == 'all' ? 'active' : '' }}">
                                Semua
                            </a>
                        </div>
                    </div>
                    
                    <!-- Results Info -->
                    <div class="text-sm text-gray-600 font-inter">
                        @if(request('per_page') !== 'all')
                            Menampilkan {{ $bukus->firstItem() ?? 0 }} - {{ $bukus->lastItem() ?? 0 }} dari {{ $bukus->total() ?? $bukus->count() }} buku
                        @else
                            Menampilkan semua {{ $bukus->count() }} buku
                        @endif
                    </div>
                </div>

                <!-- Custom Pagination Links -->
                @if(request('per_page') !== 'all' && $bukus->hasPages())
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <div class="flex items-center space-x-2 mb-4 sm:mb-0">
                        <!-- Previous Button -->
                        @if($bukus->onFirstPage())
                            <span class="pagination-btn disabled">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Sebelumnya
                            </span>
                        @else
                            <a href="{{ $bukus->appends(request()->query())->previousPageUrl() }}" class="pagination-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Sebelumnya
                            </a>
                        @endif

                        <!-- Page Numbers -->
                        <div class="flex space-x-1">
                            @php
                                $currentPage = $bukus->currentPage();
                                $lastPage = $bukus->lastPage();
                                $startPage = max(1, $currentPage - 2);
                                $endPage = min($lastPage, $currentPage + 2);
                            @endphp

                            @if($startPage > 1)
                                <a href="{{ $bukus->appends(request()->query())->url(1) }}" class="page-number">1</a>
                                @if($startPage > 2)
                                    <span class="page-ellipsis">...</span>
                                @endif
                            @endif

                            @for($page = $startPage; $page <= $endPage; $page++)
                                @if($page == $currentPage)
                                    <span class="page-number active">{{ $page }}</span>
                                @else
                                    <a href="{{ $bukus->appends(request()->query())->url($page) }}" class="page-number">{{ $page }}</a>
                                @endif
                            @endfor

                            @if($endPage < $lastPage)
                                @if($endPage < $lastPage - 1)
                                    <span class="page-ellipsis">...</span>
                                @endif
                                <a href="{{ $bukus->appends(request()->query())->url($lastPage) }}" class="page-number">{{ $lastPage }}</a>
                            @endif
                        </div>

                        <!-- Next Button -->
                        @if($bukus->hasMorePages())
                            <a href="{{ $bukus->appends(request()->query())->nextPageUrl() }}" class="pagination-btn">
                                Selanjutnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <span class="pagination-btn disabled">
                                Selanjutnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        @endif
                    </div>

                    <!-- Quick Page Jump -->
                    @if($bukus->lastPage() > 5)
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Ke halaman:</span>
                        <input type="number" 
                               min="1" 
                               max="{{ $bukus->lastPage() }}" 
                               value="{{ $bukus->currentPage() }}"
                               class="page-jump-input"
                               onchange="jumpToPage(this.value)">
                    </div>
                    @endif
                </div>
                @endif
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

        function jumpToPage(page) {
            if (page && page >= 1 && page <= {{ $bukus->lastPage() ?? 1 }}) {
                const url = new URL(window.location);
                url.searchParams.set('page', page);
                window.location.href = url.toString();
            }
        }
    </script>
</x-app-layout>