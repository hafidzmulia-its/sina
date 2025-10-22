<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Buku: ') . $managementbuku->judul }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('managementbuku.edit', $managementbuku) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('managementbuku.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Cover Image -->
                        <div class="col-span-1">
                            @if($managementbuku->cover)
                                <img src="{{ asset($managementbuku->cover) }}" alt="{{ $managementbuku->judul }}" 
                                     class="w-full h-auto object-cover rounded-lg shadow-lg">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">Tidak ada cover</span>
                                </div>
                            @endif
                        </div>

                        <!-- Book Details -->
                        <div class="col-span-2">
                            <div class="space-y-6">
                                <!-- Judul -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-700">Judul</h3>
                                    <p class="text-xl font-bold text-gray-900">{{ $managementbuku->judul }}</p>
                                </div>

                                <!-- Jenis -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-700">Jenis</h3>
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $managementbuku->jenis }}
                                    </span>
                                </div>

                                <!-- Sinopsis -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-700">Sinopsis</h3>
                                    <p class="text-gray-900 text-justify leading-relaxed">{{ $managementbuku->sinopsis }}</p>
                                </div>

                                <!-- Metadata -->
                                <div class="border-t pt-4">
                                    <h3 class="text-lg font-medium text-gray-700 mb-2">Informasi</h3>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="font-medium">Dibuat:</span>
                                            <span class="text-gray-600">{{ $managementbuku->created_at->format('d M Y H:i') }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium">Diperbarui:</span>
                                            <span class="text-gray-600">{{ $managementbuku->updated_at->format('d M Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>