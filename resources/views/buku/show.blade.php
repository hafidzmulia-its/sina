<x-app-layout>
    <style>
        .book-cover-container {
            background: white;
            border-radius: 24px;
            /* removed overflow: hidden so PNG rounded corners aren't clipped */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        .book-cover-image {
            width: 100%;
            /* enforce the book cover intrinsic ratio of 488x724 */
            aspect-ratio: 488 / 724;
            object-fit: cover;
            /* do not add border-radius; keep PNG's own rounded corners */
            border-radius: 0;
            display: block;
        }

        .related-book-cover {
            width: 100%;
            aspect-ratio: 488 / 724;
            object-fit: cover;
            border-radius: 0;
            display: block;
        }

        .related-book-card {
            background: white;
            border-radius: 16px;
            /* removed overflow: hidden so PNG rounded corners aren't clipped */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .related-book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.2);
        }
    </style>
    
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main Content Container -->
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Book Cover -->
                <div class="lg:w-1/3">
                    <div class="book-cover-container">
                        <img 
                            src="{{ $buku->cover ? asset($buku->cover) : asset('images/default-book-cover.png') }}" 
                            alt="{{ $buku->judul }}"
                            class="book-cover-image"
                        />
                    </div>
                </div>

                <!-- Book Details -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-3xl shadow-lg p-8">
                        
                        <!-- Book Title and Info -->
                        <div class="mb-6">
                            <span class="inline-block bg-teal-100 text-teal-800 text-sm font-medium px-3 py-1 rounded-full mb-3">
                                {{ $buku->jenis }}
                            </span>
                            <h1 class="text-4xl font-bold text-gray-900 mb-4 font-comfortaa">
                                {{ $buku->judul }}
                            </h1>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Progress Membaca</span>
                                <span class="text-sm text-gray-500">{{ $history->progress }}/{{ $history->target }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-teal-600 h-3 rounded-full transition-all duration-300" 
                                     style="width: {{ $history->getProgressPercentage() }}%">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ number_format($history->getProgressPercentage(), 1) }}% selesai
                            </p>
                        </div>

                        <!-- Synopsis -->
                        <div class="mb-6">
                            <p class="text-gray-600 leading-relaxed font-inter text-base">
                                {{ $buku->sinopsis }}
                            </p>
                        </div>

                        <!-- Parent Guide (Only show for orangtua role) -->
                        @if(auth()->user()->role === 'orangtua')
                        <div class="mb-6 bg-orange-50 rounded-2xl p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <img 
                                        src="{{ asset('images/parent-guide-icon.png') }}" 
                                        alt="Parent Guide"
                                        class="w-16 h-16 rounded-full object-cover"
                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iMzIiIGN5PSIzMiIgcj0iMzIiIGZpbGw9IiNGRjk5MDAiLz4KPHN2ZyB4PSIxNiIgeT0iMTYiIHdpZHRoPSIzMiIgaGVpZ2h0PSIzMiIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+CjxwYXRoIGQ9Im0zIDkgOSA5IDktOSIvPgo8L3N2Zz4KPC9zdmc+'"
                                    />
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-orange-800 mb-2 font-comfortaa">
                                        Petunjuk Orang Tua
                                    </h3>
                                    <p class="text-orange-700 text-sm font-inter">
                                        Kenalkan ilustrasi hewan di dalam cerita pada si kecil serta ajak si kecil mengetahui perasaan yang dialami tokoh pada cerita
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Action Button -->
                        <div class="flex gap-4">
                            <form method="POST" action="{{ route('buku.read', $buku) }}" class="flex-1">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 font-comfortaa text-lg"
                                    @if($history->isCompleted()) disabled @endif
                                >
                                    @if($history->isCompleted())
                                        ✓ Sudah Selesai
                                    @elseif($history->progress > 0)
                                        Lanjutkan Membaca
                                    @else
                                        Mulai Membaca
                                    @endif
                                </button>
                            </form>
                        </div>

                        <!-- Reading Stats -->
                        @if($history->progress > 0)
                        <div class="mt-6 p-4 bg-gray-50 rounded-2xl">
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-teal-600">{{ $history->progress }}</div>
                                    <div class="text-xs text-gray-500">Sesi Baca</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-orange-600">{{ $history->getRemainingTarget() }}</div>
                                    <div class="text-xs text-gray-500">Tersisa</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-green-600">{{ $history->tanggal_record->diffForHumans() }}</div>
                                    <div class="text-xs text-gray-500">Terakhir Baca</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Related Books -->
            @if($relatedBooks->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 font-fredoka">Cerita {{ $buku->jenis }} Lainnya</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-8">
                    @foreach($relatedBooks as $related)
                    <div class="related-book-card"
                         onclick="window.location.href='{{ route('buku.show', $related) }}'">
                        <img 
                            src="{{ $related->cover ? asset($related->cover) : asset('images/default-book-cover.png') }}" 
                            alt="{{ $related->judul }}"
                            class="related-book-cover"
                        />
                        <div class="p-3">
                            <h3 class="font-semibold text-gray-900 text-xs mb-1 line-clamp-2">
                                {{ Str::limit($related->judul, 25) }}
                            </h3>
                            <p class="text-xs text-teal-600">{{ $related->jenis }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>