<x-app-layout>
    <div class="text-center px-4 sm:px-6">
                <div class="relative">
                    <img 
                        src="{{ asset('images/bgtracking.png') }}" 
                        alt="Progress Background" 
                        class="w-full h-auto object-cover rounded-2xl sm:rounded-3xl"
                    />
                    <div class="absolute inset-0 flex items-center justify-center p-4">
                        <div class="text-center">
                            <h1 class="text-3xl sm:text-4xl md:text-5xl text-sina-blue mt-2 mb-3 sm:mb-5 font-bold font-comfortaa">
                                Halo {{ auth()->user()->name }}!</h1>
                                <p class="text-lg sm:text-2xl md:text-3xl text-[#303A3A] mb-4 sm:mb-8 font-inter px-2" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.25);">
                                    Minggu ini anak-anakmu sudah membaca sebanyak
                                </p>
                                <p class="text-4xl sm:text-5xl md:text-6xl font-inter font-bold text-sina-blue">{{ $weeklyProgress .' Buku' }}</p>
                        </div>
                    </div>
                </div>
            </div>
    <div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
      

            <!-- Family Stats Overview -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
                <!-- Total Children -->
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-gray-100">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="p-2 sm:p-3 bg-blue-100 rounded-full mb-2 sm:mb-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="sm:ml-4 text-center sm:text-left">
                            <p class="text-xs sm:text-sm text-gray-600 font-inter">Jumlah Anak</p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-800 font-fredoka">{{ $familyStats['totalChildren'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Books Read -->
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-gray-100">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="p-2 sm:p-3 bg-green-100 rounded-full mb-2 sm:mb-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="sm:ml-4 text-center sm:text-left">
                            <p class="text-xs sm:text-sm text-gray-600 font-inter">Total Buku</p>
                            <p class="text-xl sm:text-2xl font-bold text-green-600 font-fredoka">{{ $familyStats['totalBooksRead'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Completed Books -->
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-gray-100">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="p-2 sm:p-3 bg-purple-100 rounded-full mb-2 sm:mb-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="sm:ml-4 text-center sm:text-left">
                            <p class="text-xs sm:text-sm text-gray-600 font-inter">Buku Selesai</p>
                            <p class="text-xl sm:text-2xl font-bold text-purple-600 font-fredoka">{{ $familyStats['totalCompletedBooks'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Average Completion -->
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-lg border border-gray-100">
                    <div class="flex flex-col sm:flex-row items-center">
                        <div class="p-2 sm:p-3 bg-orange-100 rounded-full mb-2 sm:mb-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="sm:ml-4 text-center sm:text-left">
                            <p class="text-xs sm:text-sm text-gray-600 font-inter">Rata-rata Progress</p>
                            <p class="text-xl sm:text-2xl font-bold text-orange-600 font-fredoka">{{ number_format($familyStats['averageCompletionRate'], 1) }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Children Progress Cards -->
            <div class="space-y-6 sm:space-y-8">
                @forelse($childrenProgress as $childData)
                <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 shadow-lg border border-gray-100">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:space-x-6 xl:space-x-8">
                        <!-- Child Info & Stats -->
                        <div class="lg:w-1/3 mb-6 lg:mb-0">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-lg sm:text-xl font-bold">
                                    {{ strtoupper(substr($childData['child']->name, 0, 1)) }}
                                </div>
                                <div class="ml-3 sm:ml-4">
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 font-fredoka">{{ $childData['child']->name }}</h3>
                                    <p class="text-sm sm:text-base text-gray-600 font-inter">{{ '@'.$childData['child']->username }}</p>
                                </div>
                            </div>
                            
                            <!-- Progress Stats -->
                            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                <div class="text-center p-3 sm:p-4 bg-blue-50 rounded-lg">
                                    <p class="text-xl sm:text-2xl font-bold text-blue-600 font-fredoka">{{ $childData['totalBooks'] }}</p>
                                    <p class="text-xs text-gray-600">Total Buku</p>
                                </div>
                                <div class="text-center p-3 sm:p-4 bg-green-50 rounded-lg">
                                    <p class="text-xl sm:text-2xl font-bold text-green-600 font-fredoka">{{ $childData['completedBooks'] }}</p>
                                    <p class="text-xs text-gray-600">Selesai</p>
                                </div>
                                <div class="text-center p-3 sm:p-4 bg-orange-50 rounded-lg">
                                    <p class="text-xl sm:text-2xl font-bold text-orange-600 font-fredoka">{{ $childData['streak'] }}</p>
                                    <p class="text-xs text-gray-600">Hari Streak</p>
                                </div>
                                <div class="text-center p-3 sm:p-4 bg-purple-50 rounded-lg">
                                    <p class="text-xl sm:text-2xl font-bold text-purple-600 font-fredoka">{{ $childData['weeklyProgress'] }}</p>
                                    <p class="text-xs text-gray-600">Hal/Minggu</p>
                                </div>
                            </div>

                            <!-- Completion Progress Circle -->
                            <div class="mt-6 text-center">
                                <div class="relative inline-flex items-center justify-center w-24 h-24">
                                    <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 100 100">
                                        <circle cx="50" cy="50" r="40" fill="none" stroke="#e5e7eb" stroke-width="6"></circle>
                                        <circle 
                                            cx="50" 
                                            cy="50" 
                                            r="40" 
                                            fill="none" 
                                            stroke="#10b981" 
                                            stroke-width="6"
                                            stroke-linecap="round"
                                            stroke-dasharray="{{ 2 * pi() * 40 }}"
                                            stroke-dashoffset="{{ 2 * pi() * 40 * (1 - $childData['completionRate'] / 100) }}"
                                        ></circle>
                                    </svg>
                                    <span class="absolute text-sm font-bold text-gray-800">{{ number_format($childData['completionRate'], 0) }}%</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-2">Tingkat Penyelesaian</p>
                            </div>
                        </div>

                        <!-- Recent Activities -->
                        <div class="lg:w-2/3">
                            <h4 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4 font-fredoka">Aktivitas Terbaru</h4>
                            @if($childData['recentActivities']->count() > 0)
                                <div class="space-y-2 sm:space-y-3 max-h-64 sm:max-h-80 overflow-y-auto">
                                    @foreach($childData['recentActivities'] as $activity)
                                    <div class="flex items-center p-2 sm:p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <img 
                                            src="{{ $activity->buku->cover ? asset($activity->buku->cover) : asset('images/default-book-cover.png') }}" 
                                            alt="{{ $activity->buku->judul }}"
                                            class="w-8 h-10 sm:w-10 sm:h-12 object-cover rounded flex-shrink-0"
                                        />
                                        <div class="ml-2 sm:ml-3 flex-1 min-w-0">
                                            <h5 class="text-xs sm:text-sm font-medium text-gray-800 truncate">{{ $activity->buku->judul }}</h5>
                                            <p class="text-xs text-gray-600">
                                               {{ number_format($activity->getProgressPercentage(), 0) }}% complete
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $activity->tanggal_record->format('d M Y') }}</p>
                                        </div>
                                        <div class="ml-2 sm:ml-3 flex-shrink-0">
                                            @if($activity->isCompleted())
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    ✓
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    📖
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p>Belum ada aktivitas membaca</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Performance Indicator -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                    @if($childData['completionRate'] >= 80)
                            <div class="bg-green-100 border border-green-200 rounded-lg p-4 text-center">
                                <p class="text-green-800 font-medium">🌟 {{ $childData['child']->name }} sangat rajin membaca!</p>
                            </div>
                        @elseif($childData['completionRate'] >= 50)
                            <div class="bg-blue-100 border border-blue-200 rounded-lg p-4 text-center">
                                <p class="text-blue-800 font-medium">👍 {{ $childData['child']->name }} menunjukkan progress yang baik</p>
                            </div>
                        @elseif($childData['completionRate'] >= 20)
                            <div class="bg-yellow-100 border border-yellow-200 rounded-lg p-4 text-center">
                                <p class="text-yellow-800 font-medium">📚 {{ $childData['child']->name }} perlu didorong untuk membaca lebih banyak</p>
                            </div>
                        @else
                            <div class="bg-red-100 border border-red-200 rounded-lg p-4 text-center">
                                <p class="text-red-800 font-medium">🎯 {{ $childData['child']->name }} membutuhkan motivasi lebih untuk membaca</p>
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-2xl p-12 shadow-lg border border-gray-100 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Anak Terdaftar</h3>
                    <p class="text-gray-600">Tambahkan akun anak untuk mulai memantau progress membaca mereka.</p>
                </div>
                @endforelse
            </div>

            <!-- Tips Section -->
            <div class="mt-6 sm:mt-8 bg-gradient-to-r from-teal-500 to-blue-600 rounded-xl sm:rounded-2xl p-6 sm:p-8 text-center text-white">
                <h3 class="text-xl sm:text-2xl font-bold mb-4 font-fredoka">Tips untuk Orang Tua</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mt-4 sm:mt-6">
                    <div class="bg-white/10 rounded-lg p-3 sm:p-4">
                        <div class="text-2xl sm:text-3xl mb-2">📚</div>
                        <h4 class="font-semibold mb-2 text-sm sm:text-base">Buat Jadwal Membaca</h4>
                        <p class="text-xs sm:text-sm">Tentukan waktu khusus setiap hari untuk membaca bersama anak</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-3 sm:p-4">
                        <div class="text-2xl sm:text-3xl mb-2">🎯</div>
                        <h4 class="font-semibold mb-2 text-sm sm:text-base">Berikan Reward</h4>
                        <p class="text-xs sm:text-sm">Apresiasi pencapaian anak dengan hadiah atau pujian</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-3 sm:p-4">
                        <div class="text-2xl sm:text-3xl mb-2">💬</div>
                        <h4 class="font-semibold mb-2 text-sm sm:text-base">Diskusi Cerita</h4>
                        <p class="text-xs sm:text-sm">Tanyakan tentang cerita yang dibaca untuk meningkatkan pemahaman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>