<x-app-layout>
    <div class="py-4 px-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Akun Baru') }}
            </h2>
            <a href="{{ route('account.index', ['type' => $type]) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('account.store') }}" x-data="{ role: '{{ old('role', 'anak') }}' }">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">

                        <!-- Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="mb-6">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input type="text" name="username" id="username" value="{{ old('username') }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Username harus unik dan akan digunakan untuk login</p>
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <select name="role" id="role" x-model="role"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                    required>
                                <option value="">Pilih Role</option>
                                @foreach($availableRoles as $roleOption)
                                    <option value="{{ $roleOption }}" {{ old('role') == $roleOption ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $roleOption)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Child Username (only shown if role is orangtua) -->
                        <div class="mb-6" x-show="role === 'orangtua'" x-transition>
                            <label for="child_username" class="block text-sm font-medium text-gray-700 mb-2">Pilih Anak (Opsional)</label>
                            <select name="child_username" id="child_username" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Pilih Anak (Opsional)</option>
                                @foreach($availableChildren as $child)
                                    <option value="{{ $child->username }}" {{ old('child_username') == $child->username ? 'selected' : '' }}>
                                        {{ $child->name }} ({{ $child->username }})
                                    </option>
                                @endforeach
                            </select>
                            @error('child_username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Pilih anak yang akan dihubungkan dengan orang tua ini</p>
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input type="password" name="password" id="password" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                   required>
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>