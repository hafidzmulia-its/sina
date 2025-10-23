<x-app-layout>
    <div class=" text-center">
                <div class="relative">
                    <img 
                        src="{{ asset('images/bgtracking.png') }}" 
                        alt="Progress Background" 
                        class="w-full h-auto object-cover rounded-3xl"
                    />
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <!-- <img 
                                src="{{ asset('images/logobuku.png') }}" 
                                alt="Book Logo" 
                                class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-4"
                            /> -->

                            <h1 class="text-5xl text-sina-blue mt-2 mb-5 font-bold font-comfortaa">
                                Halo {{ auth()->user()->name }}!</h1>
                                <p class="text-3xl text-[#303A3A] mb-8 font-inter" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.25);">
                                    Minggu ini kamu sudah membaca sebanyak
                                </p>
                                <p class="text-6xl font-inter font-bold text-sina-blue">{{ $weeklyProgress .' Buku' }}</p>
                        </div>
                    </div>
                </div>
            </div>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Weekly Progress Card (Left) -->
                <div class="bg-sina-blue rounded-3xl p-4 shadow-lg text-white relative overflow-hidden" style="min-height: 200px;">
                    <div class="flex items-center justify-between h-full">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div class="flex items-center justify-center w-40 h-40">
                                    <svg class="w-40 h-40" viewBox="0 0 160 160" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Completion progress">
                                        <!-- Track -->
                                        <circle cx="80" cy="80" r="60" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="12" transform="rotate(-90 80 80)"></circle>

                                        <!-- Progress (rotated so 0% starts at top) -->
                                        <circle
                                            cx="80"
                                            cy="80"
                                            r="60"
                                            fill="none"
                                            stroke="white"
                                            stroke-width="12"
                                            stroke-linecap="round"
                                            stroke-dasharray="{{ 2 * pi() * 60 }}"
                                            stroke-dashoffset="{{ 2 * pi() * 60 * (1 - $completionRate / 100) }}"
                                            transform="rotate(-90 80 80)"
                                            class="transition-all duration-1000 ease-out"
                                        ></circle>

                                        <!-- Centered text -->
                                        <text x="80" y="80" text-anchor="middle" dominant-baseline="middle" fill="white" font-size="38" font-weight="500" class="font-fredoka">
                                            {{ number_format($completionRate, 0) }}%
                                        </text>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-white/90 font-inter font-bold text-3xl">Proses Mingguan</p>
                                    <p class="text-white/70 font-inter text-2xl ">Target bacaan per minggu</p>
                                </div>
                            </div>

                            <!-- additional left-card content can go here -->
                        </div>
                        <!-- end flex-1 -->
                    </div>
                </div>

                <!-- Total Books Card (Right) -->
                <div class="bg-[#E7C3A2] rounded-3xl p-4 shadow-lg text-[#2D4A3A] relative overflow-hidden" style="min-height: 200px;">
                    <div class="flex items-center justify-between h-full">
                        <div class="flex items-center">
                            <div class="w-28 h-28 rounded-full flex items-center justify-center mx-8">
                                <!-- <svg class="w-8 h-8 text-[#2D4A3A]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19ZM17 9H7V7H17V9ZM17 13H7V11H17V13ZM17 17H7V15H17V17Z"/>
                                </svg> -->
                                <img src="{{ asset('images/logobuku.png') }}" class="w-full" alt="">
                            </div>
                            <div>
                                <h3 class="text-[#373D63] font-inter font-bold text-4xl">{{ $totalBooks }} <span >Buku</span></h3>
                                <p class="text-[#2D4A3A]/70 font-inter text-2xl">Total yang telah dibaca</p>
                            </div>
                        </div>
                        <!-- <div class="opacity-20">
                            <svg class="w-16 h-16 text-[#2D4A3A]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M19 19H5V5H19V19ZM17 12H7V14H17V12ZM17 9H7V11H17V9ZM17 6H7V8H17V6Z"/>
                            </svg>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Books -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600 font-inter">Total Buku</p>
                            <p class="text-2xl font-bold text-gray-800 font-fredoka">{{ $totalBooks }}</p>
                        </div>
                    </div>
                </div>

                <!-- Completed Books -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600 font-inter">Selesai Dibaca</p>
                            <p class="text-2xl font-bold text-green-600 font-fredoka">{{ $completedBooks }}</p>
                        </div>
                    </div>
                </div>

                <!-- Reading Streak -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-full">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600 font-inter">Streak Membaca</p>
                            <p class="text-2xl font-bold text-orange-600 font-fredoka">{{ $streak }} hari</p>
                        </div>
                    </div>
                </div>

                <!-- Completion Rate -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600 font-inter">Tingkat Selesai</p>
                            <p class="text-2xl font-bold text-purple-600 font-fredoka">{{ number_format($completionRate, 1) }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Chart Section -->
            

            <!-- Recent Activities -->
            @if($recentActivities->count() > 0)
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 mb-6 font-fredoka">Aktivitas Membaca Terakhir</h3>
                <div class="space-y-4">
                    @foreach($recentActivities as $activity)
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <img 
                            src="{{ $activity->buku->cover ? asset($activity->buku->cover) : asset('images/default-book-cover.png') }}" 
                            alt="{{ $activity->buku->judul }}"
                            class="w-12 h-16 object-cover rounded-lg"
                        />
                        <div class="ml-4 flex-1">
                            <h4 class="font-semibold text-gray-800 font-inter">{{ $activity->buku->judul }}</h4>
                            <p class="text-sm text-gray-600">
                                Progress: {{ $activity->getProgressPercentage() }}% 
                                ({{ $activity->progress }}/{{ $activity->target }} halaman)
                            </p>
                            <p class="text-xs text-gray-500">{{ $activity->tanggal_record->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            @if($activity->isCompleted())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✓ Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    📖 Dalam Progress
                                </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Motivational Section -->
            <div class="mt-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-8 text-center text-white">
                <h3 class="text-2xl font-bold mb-4 font-fredoka">Terus Semangat Membaca!</h3>
                <p class="text-lg mb-6 font-comfortaa">
                    @if($completionRate >= 80)
                        Wow! Kamu hampir menyelesaikan semua buku. Kamu luar biasa! 🌟
                    @elseif($completionRate >= 50)
                        Kamu sudah setengah jalan! Terus semangat ya! 📚
                    @elseif($completionRate >= 20)
                        Mulai yang bagus! Ayo baca lebih banyak lagi! 🚀
                    @else
                        Setiap halaman yang dibaca adalah langkah menuju pengetahuan baru! 💪
                    @endif
                </p>
                <a href="{{ route('buku.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-full hover:bg-gray-100 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Jelajahi Buku Lainnya
                </a>
            </div>
        </div>
    </div>
</x-app-layout>