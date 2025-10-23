
<nav x-data="{ open: false }" class="bg-nav ">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-20 py-3">
        <div class="flex justify-between items-center h-16">
            <!-- Left Side: Logo and Search -->
            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo_sina.png') }}" alt="Sina Logo" class="h-8 w-auto">
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:block">
                    <form action="{{ route('buku.index') }}" method="GET" class="relative">
                        <!-- Preserve current filter if exists -->
                        @if(request('jenis'))
                            <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                        @endif
                        
                        <input type="text" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Apa yang ingin kamu baca hari ini" 
                               class="w-80 px-4 py-2 pl-4 pr-10 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent font-dmsans">
                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side: Navigation Links and Profile -->
            <div class="hidden sm:flex sm:items-center text-lg sm:space-x-12">
                <!-- Navigation Links -->
                <div class="flex space-x-12">
                    <a href="{{ route('buku.index') }}" class="text-teal-600 font-medium font-dmsans hover:text-teal-700 transition">Jenis Buku</a>
                    <a href="#" class="text-teal-600 font-medium font-dmsans hover:text-teal-700 transition">Progress</a>
                </div>

                <!-- Profile Section -->
                <div class="flex items-center space-x-5">
                    <!-- Child Profile -->
                    @if(Auth::user()->isAnak())
                        <div class="flex items-center space-x-5 bg-[#5C8D8D] rounded-full py-1 pl-1 w-28">
                            <img src="{{ asset('images/profil_anak.png') }}" alt="Profil Anak" class="h-6 w-6 rounded-full">
                            <span class="font-fredoka text-sm font-medium text-white">Anak</span>
                        </div>
                    @elseif(Auth::user()->isOrangTua())
                        <div class="flex items-center space-x-5 bg-[#5C8D8D] rounded-full py-1 pl-1 w-36">
                            <img src="{{ asset('images/profil_orangtua.png') }}" alt="Profil Orang Tua" class="h-6 w-6 rounded-full">
                            <span class="font-fredoka text-sm font-medium text-white">Orang Tua</span>
                        </div>
                    @elseif(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                        <a href="{{ route('managementbuku.index') }}" class="text-teal-600 font-medium font-dmsans hover:text-teal-700 transition">
                            Manajemen Buku
                        </a>
                        <a href="{{ route('account.index') }}" class="text-teal-600 font-medium font-dmsans hover:text-teal-700 transition">
                            Manajemen Akun
                        </a>
                    @endif

                    <!-- Settings Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition ease-in-out duration-150">
                                <img src="{{ asset('images/profile.png') }}" alt="Profile" class="h-12 w-12 rounded-full">
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <!-- Mobile Search -->
        <div class="px-4 py-3 border-b border-gray-200">
            <form action="{{ route('buku.index') }}" method="GET" class="relative">
                @if(request('jenis'))
                    <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                @endif
                
                <input type="text" 
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Apa yang ingin kamu baca hari ini" 
                       class="w-full px-4 py-2 pl-4 pr-10 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent font-dmsans">
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Mobile Navigation Links -->
        <div class="pt-2 pb-3 space-y-1 font-dmsans">
            <a href="{{ route('buku.index') }}" class="block px-4 py-2 text-base font-medium text-teal-600 hover:text-teal-700 hover:bg-gray-50 transition">Jenis Buku</a>
            <a href="#" class="block px-4 py-2 text-base font-medium text-teal-600 hover:text-teal-700 hover:bg-gray-50 transition">Progress</a>
        </div>

        <!-- Mobile Profile Section -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4 space-x-3">
                @if(Auth::user()->isAnak())
                    <img src="{{ asset('images/profil_anak.png') }}" alt="Profil Anak" class="h-10 w-10 rounded-full">
                @elseif(Auth::user()->isOrangTua())
                    <img src="{{ asset('images/profil_orangtua.png') }}" alt="Profil Orang Tua" class="h-10 w-10 rounded-full">
                @endif
                <div>
                    <div class="font-medium text-base text-gray-800 font-dmsans">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 font-dmsans">
                        @if(Auth::user()->isAnak())
                            Anak
                        @elseif(Auth::user()->isOrangTua())
                            Orang Tua
                        @elseif(Auth::user()->isAdmin())
                            Admin
                        @elseif(Auth::user()->isSuperAdmin())
                            Super Admin
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>