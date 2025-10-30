<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-2 sm:p-4">
        <!-- Main Container -->
        <div class="login-container w-full overflow-hidden relative">
            
            <!-- Background Image Area -->
            <div class="absolute inset-0">
                <img 
                    src="{{ asset('images/login.png') }}" 
                    alt="Background" 
                    width="1200" 
                    height="800" 
                    class="w-full h-full object-cover object-center"
                />
            </div>
            
            <!-- Form Card -->
            <div class="absolute inset-0 flex items-center justify-center md:justify-end md:pr-4 lg:pr-8 z-10">
                <div class="login-card rounded-2xl sm:rounded-3xl px-6 sm:px-10 md:px-14 py-8 sm:py-12 md:py-16 relative">
                    
                    <!-- Decorative Stars (hidden on mobile) -->
                    <div class="star star-white absolute top-6 right-32 sm:right-36 md:right-44 hidden sm:block">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-8 sm:w-10 h-8 sm:h-10" style="transform: rotate(7deg);">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    </div>
                    <div class="star star-pink absolute top-5 right-12 sm:right-16 hidden sm:block">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-8 sm:w-10 h-8 sm:h-10" style="transform: rotate(-7deg);">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    </div>
                    <div class="star star-purple absolute top-10 right-20 sm:right-28 hidden sm:block">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-8 sm:w-10 h-8 sm:h-10" style="transform: rotate(-22deg);">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="login-title text-center sm:text-start text-[#F1DEDE] mb-3 sm:mb-5">Reset Password</h1>
                    
                    <!-- Description -->
                    <p class="text-white text-opacity-90 text-xs sm:text-sm mb-6 sm:mb-8 font-comfortaa text-center sm:text-left leading-relaxed">
                        Lupa password? Tidak masalah. Masukkan email kamu dan kami akan mengirimkan link reset password.
                    </p>
                    
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    
                    @if (session('status'))
                        <div class="mb-4 text-sm text-white bg-white bg-opacity-20 rounded-lg p-3 font-comfortaa">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.email') }}" class="space-y-4 sm:space-y-6">
                        @csrf

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="form-label">Email</label>
                            <input 
                                id="email" 
                                class="form-input" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                                placeholder="Enter your email address"
                            />
                            @error('email')
                                <div class="error-message text-white text-xs mt-2 bg-red-500 bg-opacity-30 rounded-lg p-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center pt-1 sm:pt-2">
                            <button type="submit" class="login-button w-full sm:w-3/4">
                                Kirim Link Reset
                            </button>
                        </div>
                        
                        <!-- Back to Login Link -->
                        <div class="text-center mt-2 sm:mt-3 pb-1 sm:pb-2">
                            <a class="text-white text-xs sm:text-sm hover:underline font-medium transition-all duration-200" href="{{ route('login') }}">
                                ← Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
