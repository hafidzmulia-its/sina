<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Akun: ') . $account->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('account.edit', $account) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('account.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Account Information -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-700 border-b pb-2">Informasi Akun</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                <p class="text-lg text-gray-900">{{ $account->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Username</label>
                                <p class="text-lg text-gray-900">{{ $account->username }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="text-lg text-gray-900">{{ $account->email }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Role</label>
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    {{ $account->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : 
                                       ($account->role === 'admin' ? 'bg-blue-100 text-blue-800' : 
                                       ($account->role === 'orangtua' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $account->role)) }}
                                </span>
                            </div>
                        </div>

                        <!-- Relationships -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-700 border-b pb-2">Hubungan</h3>
                            
                            @if($account->role === 'orangtua')
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Anak</label>
                                    @if($account->children->count() > 0)
                                        <div class="space-y-2 mt-2">
                                            @foreach($account->children as $child)
                                                <div class="bg-gray-50 p-3 rounded">
                                                    <p class="font-medium">{{ $child->name }}</p>
                                                    <p class="text-sm text-gray-600">Username: {{ $child->username }}</p>
                                                    <p class="text-sm text-gray-600">Email: {{ $child->email }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500">Tidak ada anak terhubung</p>
                                    @endif
                                </div>
                            @elseif($account->role === 'anak')
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Orang Tua</label>
                                    @if($account->parent)
                                        <div class="bg-gray-50 p-3 rounded mt-2">
                                            <p class="font-medium">{{ $account->parent->name }}</p>
                                            <p class="text-sm text-gray-600">Username: {{ $account->parent->username }}</p>
                                            <p class="text-sm text-gray-600">Email: {{ $account->parent->email }}</p>
                                        </div>
                                    @else
                                        <p class="text-gray-500">Tidak ada orang tua terhubung</p>
                                    @endif
                                </div>
                            @endif

                            <!-- Activity History -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Aktivitas Terakhir</label>
                                <div class="mt-2 space-y-2">
                                    <div class="text-sm">
                                        <span class="font-medium">Dibuat:</span>
                                        <span class="text-gray-600">{{ $account->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <div class="text-sm">
                                        <span class="font-medium">Diperbarui:</span>
                                        <span class="text-gray-600">{{ $account->updated_at->format('d M Y H:i') }}</span>
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