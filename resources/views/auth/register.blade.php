
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center ">
        <!-- Main Register Container -->
        <div class="register-container w-full overflow-hidden relative">
            
            <!-- Background Image Area -->
      <div class="absolute top-0 right-0 m-0 p-0">
            <img 
                src="{{ asset('images/signup.png') }}" 
                alt="Background" 
                class="block m-0 p-0"
                style="margin: 0; padding: 0;"
            />
        </div>
            
            <!-- Sina Logo (Top Right) -->
            <!-- <div class="absolute top-8 right-8 z-10">
                <div class="text-gray-600 text-3xl font-semibold font-comfortaa">sina</div>
            </div> -->
            
            <!-- Register Form Card (Left Side) -->
            <div class="absolute left-8 top-1/2 transform -translate-y-1/2 z-10 md:relative md:left-auto md:top-auto md:transform-none md:flex md:justify-start md:items-center md:h-full md:pl-8">
                <div class="register-card rounded-3xl w-1/2 justify-center py-8 flex flex-col items-center ">
                    
                    <!-- Register Title -->
                    <h1 class="register-title text-left text-[#46798E] text-6xl mb-6 font-comfortaa font-medium">Sign Up</h1>
                    
                    <!-- Register Form -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-4 font-inter" x-data="{ role: '{{ old('role', 'anak') }}', showPassword: false }">
                        @csrf
                        
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="register-label">Name</label>
                            <input 
                                id="name" 
                                class="register-input" 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus 
                                autocomplete="name"
                                placeholder="Enter your full name"
                            />
                            @error('name')
                                <div class="error-message-register">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Username Field -->
                        <div>
                            <label for="username" class="register-label">Username</label>
                            <input 
                                id="username" 
                                class="register-input" 
                                type="text" 
                                name="username" 
                                value="{{ old('username') }}" 
                                required 
                                autocomplete="username"
                                placeholder="Enter your username"
                            />
                            @error('username')
                                <div class="error-message-register">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="register-label">Email</label>
                            <input 
                                id="email" 
                                class="register-input" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="email"
                                placeholder="Enter your email"
                            />
                            @error('email')
                                <div class="error-message-register">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password Field with Show/Hide -->
                        <div>
                            <label for="password" class="register-label">Password</label>
                            <div class="relative">
                                <input 
                                    id="password" 
                                    class="register-input pr-12"
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    required 
                                    autocomplete="new-password"
                                    placeholder="Enter your password"
                                />
                                <button 
                                    type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                                >
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="error-message-register">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Role Selection -->
                        <div>
                            <label class="register-label">Siapa yang menggunakan akun ini?</label>
                            <div class="role-selection mt-3">
                                <!-- Orang Tua Option -->
                                <label class="role-option w-1/2">
                                    <input 
                                        type="radio" 
                                        name="role" 
                                        value="orangtua" 
                                        x-model="role"
                                        class="role-radio"
                                        {{ old('role') == 'orangtua' ? 'checked' : '' }}
                                    />
                                    <div class="role-card">
                                        <img src="{{ asset('images/profil_orangtua.png') }}" alt="Orang Tua" class="role-avatar">
                                        <span class="role-text">Orang Tua</span>
                                    </div>
                                </label>
                                
                                <!-- Anak Option -->
                                <label class="role-option w-1/2">
                                    <input 
                                        type="radio" 
                                        name="role" 
                                        value="anak" 
                                        x-model="role"
                                        class="role-radio"
                                        {{ old('role', 'anak') == 'anak' ? 'checked' : '' }}
                                    />
                                    <div class="role-card">
                                        <img src="{{ asset('images/profil_anak.png') }}" alt="Anak" class="role-avatar">
                                        <span class="role-text">Anak</span>
                                    </div>
                                </label>
                            </div>
                            @error('role')
                                <div class="error-message-register">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Child Username (only shown if role is orangtua) -->
                        <div x-show="role === 'orangtua'" x-transition class="child-username-field">
                            <label for="child_username" class="register-label">Username Anak</label>
                            <input 
                                id="child_username" 
                                class="register-input" 
                                type="text" 
                                name="child_username" 
                                value="{{ old('child_username') }}" 
                                autocomplete="off"
                                placeholder="Masukkan username anak yang sudah terdaftar"
                            />
                            @error('child_username')
                                <div class="error-message-register">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-center pt-4">
                            <button type="submit" class="register-button">
                                Sign Up
                            </button>
                        </div>
                        
                        <!-- Login Link -->
                        <div class="text-center mt-4">
                            <a class="login-link" href="{{ route('login') }}">
                                Already have an account? <span class="font-semibold">Login</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>