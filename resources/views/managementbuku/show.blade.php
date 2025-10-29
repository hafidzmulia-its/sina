<x-app-layout>
    <div class="h-[calc(100vh-80px)] flex items-center justify-center px-4">
        <div class="w-4/5 h-[70vh] bg-[#C7D4CE] rounded-[3rem] py-12 shadow-2xl">
            <div class="h-full flex flex-col">
                <!-- Header with Action Buttons -->
                <div class="flex justify-between items-center mb-0 px-12">
                    <h2 class="text-2xl font-bold text-gray-800 font-comfortaa">
                        Detail Buku: {{ $managementbuku->judul }}
                    </h2>
                    <div class="flex gap-3">
                        <a href="{{ route('managementbuku.edit', $managementbuku) }}" class="bg-[#F59E0B] hover:bg-[#D97706] text-white font-medium py-2 px-6 rounded-full transition-colors duration-300">
                            Edit
                        </a>
                        <a href="{{ route('managementbuku.index') }}" class="bg-[#A8B5B3] hover:bg-[#95A8A5] text-white font-medium py-2 px-6 rounded-full transition-colors duration-300">
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Content Container -->
                <div class="flex-1 overflow-y-auto px-12  flex items-center">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 w-full">
                        
                        <!-- Left Column - Cover Image -->
                        <div class="flex flex-col  space-y-6">
                            <!-- Cover Display -->
                            <div class=" rounded-2xl  flex justify-center">
                                @if($managementbuku->cover)
                                    <img src="{{ asset($managementbuku->cover) }}" 
                                         alt="{{ $managementbuku->judul }}" 
                                         class="h-80 w-auto object-cover rounded-xl shadow-lg">
                                @else
                                    <div class="w-full h-64 bg-gray-100 rounded-xl flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="text-gray-500 font-inter">Tidak ada cover</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Metadata Card -->
                            <div class="bg-white rounded-2xl p-6 shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 font-comfortaa">Informasi Buku</h3>
                                <div class="space-y-3 text-sm font-inter">
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-600">Dibuat:</span>
                                        <span class="text-gray-800">{{ $managementbuku->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-600">Diperbarui:</span>
                                        <span class="text-gray-800">{{ $managementbuku->updated_at->format('d M Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Book Details -->
                        <div class="space-y-6">
                            <!-- Title and Genre -->
                            <div class="bg-white rounded-2xl p-6 shadow-sm">
                                <div class="space-y-4">
                                    <!-- Title -->
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-600 mb-2 font-inter">Judul Buku</h3>
                                        <p class="text-2xl font-bold text-gray-900 font-comfortaa">{{ $managementbuku->judul }}</p>
                                    </div>

                                    <!-- Genre -->
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-600 mb-2 font-inter">Jenis</h3>
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-[#46798E] text-white">
                                            {{ $managementbuku->jenis }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Synopsis -->
                            <div class="bg-white rounded-2xl p-6 shadow-sm flex-1">
                                <h3 class="text-sm font-medium text-gray-600 mb-3 font-inter">Sinopsis</h3>
                                <div class="bg-gray-50 rounded-xl p-4 h-48 overflow-y-auto">
                                    <p class="text-gray-900 leading-relaxed font-inter text-justify">{{ $managementbuku->sinopsis }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>