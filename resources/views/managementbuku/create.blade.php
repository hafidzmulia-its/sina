<x-app-layout>
    <div class="h-[calc(100vh-80px)] flex items-center justify-center px-4">
        <div class="w-4/5 h-[70vh] bg-[#C7D4CE] rounded-[3rem] py-12 shadow-2xl">
            <div class="h-full flex flex-col">
                <!-- Header with Back Button -->
                <div class="flex justify-between items-center mb-8 px-12">
                    <h2 class="text-2xl font-bold text-gray-800 font-comfortaa">
                        Tambah Buku Baru
                    </h2>
                    <a href="{{ route('managementbuku.index') }}" class="bg-[#A8B5B3] hover:bg-[#95A8A5] text-white font-medium py-2 px-6 rounded-full transition-colors duration-300">
                        Kembali
                    </a>
                </div>

                <!-- Form Container -->
                <div class="flex-1 overflow-y-auto px-12">
                    <form method="POST" action="{{ route('managementbuku.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-8 h-full">
                        @csrf
                        
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Judul Buku -->
                            <div>
                                <label for="judul" class="block text-gray-700 font-medium mb-3 font-inter">
                                    Judul Buku
                                </label>
                                <input type="text" 
                                       name="judul" 
                                       id="judul" 
                                       value="{{ old('judul') }}" 
                                       placeholder="Ketik judul buku"
                                       class="w-full bg-white rounded-2xl border-0 px-4 py-3 text-gray-700 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-[#46798E] focus:outline-none font-inter" 
                                       required>
                                @error('judul')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis -->
                            <div>
                                <label for="jenis" class="block text-gray-700 font-medium mb-3 font-inter">
                                    Jenis
                                </label>
                                <select name="jenis" 
                                        id="jenis" 
                                        class="w-full bg-white rounded-2xl border-0 px-4 py-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-[#46798E] focus:outline-none font-inter appearance-none" 
                                        required>
                                    <option value="">Pilih</option>
                                    @foreach($jenisOptions as $option)
                                        <option value="{{ $option }}" {{ old('jenis') == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Upload File Cover -->
                            <div>
                                <label for="cover" class="block text-gray-700 font-medium mb-3 font-inter">
                                    Upload File Cover
                                </label>
                                <div class="relative">
                                    <input type="file" 
                                           name="cover" 
                                           id="cover" 
                                           accept="image/*"
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                           required 
                                           onchange="previewImage(this)">
                                    <div class="bg-white rounded-2xl border-0 px-4 py-3 shadow-sm flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors">
                                        <span class="text-gray-500 font-inter" id="fileLabel">Pilih File</span>
                                        <div class="bg-[#46798E] text-white px-4 py-2 rounded-xl text-sm font-medium">
                                            Browse
                                        </div>
                                    </div>
                                </div>
                                @error('cover')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="mt-4 hidden">
                                    <img id="preview" src="#" alt="Preview" class="h-32 w-24 object-cover rounded-xl border">
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Sinopsis -->
                            <div class="h-4/5 flex flex-col">
                                <label for="sinopsis" class="block text-gray-700 font-medium mb-3 font-inter">
                                    Sinopsis
                                </label>
                                <textarea name="sinopsis" 
                                         id="sinopsis" 
                                         placeholder="Ketik Sinopsis Cerita"
                                         class="flex-1 w-full bg-white rounded-2xl border-0 px-4 py-3 text-gray-700 placeholder-gray-400 shadow-sm focus:ring-2 focus:ring-[#46798E] focus:outline-none resize-none font-inter" 
                                         required>{{ old('sinopsis') }}</textarea>
                                @error('sinopsis')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-4 justify-end mt-6">
                                <button type="button" 
                                        onclick="window.location.href='{{ route('managementbuku.index') }}'"
                                        class="bg-[#D1B3A6] hover:bg-[#C4A393] text-white font-medium py-3 px-8 rounded-full transition-colors duration-300 font-inter">
                                    Batal
                                </button>
                                <button type="submit" 
                                        class="bg-[#46798E] hover:bg-[#3A6B7D] text-white font-medium py-3 px-8 rounded-full transition-colors duration-300 font-inter">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function previewImage(input) {
        const fileLabel = document.getElementById('fileLabel');
        
        if (input.files && input.files[0]) {
            // Update file label
            fileLabel.textContent = input.files[0].name;
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            fileLabel.textContent = 'Pilih File';
            document.getElementById('imagePreview').classList.add('hidden');
        }
    }
    </script>
</x-app-layout>