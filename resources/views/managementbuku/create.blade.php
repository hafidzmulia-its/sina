<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Buku Baru') }}
            </h2>
            <a href="{{ route('managementbuku.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('managementbuku.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Judul -->
                        <div class="mb-6">
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Buku</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis -->
                        <div class="mb-6">
                            <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis Buku</label>
                            <select name="jenis" id="jenis" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    required>
                                <option value="">Pilih Jenis Buku</option>
                                @foreach($jenisOptions as $option)
                                    <option value="{{ $option }}" {{ old('jenis') == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cover Image -->
                        <div class="mb-6">
                            <label for="cover" class="block text-sm font-medium text-gray-700 mb-2">Cover Buku</label>
                            <input type="file" name="cover" id="cover" accept="image/*"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required onchange="previewImage(this)">
                            @error('cover')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-4 hidden">
                                <img id="preview" src="#" alt="Preview" class="h-32 w-24 object-cover rounded border">
                            </div>
                        </div>

                        <!-- Sinopsis -->
                        <div class="mb-6">
                            <label for="sinopsis" class="block text-sm font-medium text-gray-700 mb-2">Sinopsis</label>
                            <textarea name="sinopsis" id="sinopsis" rows="6" 
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                      required>{{ old('sinopsis') }}</textarea>
                            @error('sinopsis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                Simpan Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</x-app-layout>