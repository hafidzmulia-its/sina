<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- Main Login Container -->
        <div class="login-container w-full overflow-hidden relative">
            
            <!-- Background Image Area -->
            <div class="absolute inset-0">
                <img 
                    src="{{ asset('images/login.png') }}" 
                    alt="Background" 
                    width="1200" 
                    height="800" 
                    class="w-full h-full"
                />
            </div>
            
            <!-- Login Form Card (Right Side) -->
            <div class="absolute right-8 top-1/2 transform -translate-y-1/2 z-10 md:relative md:right-auto md:top-auto md:transform-none md:flex md:justify-end md:items-center md:h-full md:pr-8">
                <div class="login-card rounded-3xl w-2/5 px-14 pt-16 pb-12 relative">
                    
                    <!-- Decorative Stars -->
                    <div class="star star-white absolute top-6 right-44">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10" style="transform: rotate(7deg); transform-origin: center; transform-box: fill-box;">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    </div>
                    <div class="star star-pink absolute top-5 right-16">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10" style="transform: rotate(-7deg); transform-origin: center; transform-box: fill-box;">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    </div>
                    <div class="star star-purple absolute top-10 right-28">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10" style="transform: rotate(-22deg); transform-origin: center; transform-box: fill-box;">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    </div>
                    
                    <!-- Login Title -->
                    <h1 class="login-title text-start text-[#F1DEDE] text-7xl mb-7">Login</h1>
                    
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    
                    @if (session('status'))
                        <div class="mb-4 text-sm text-white bg-white bg-opacity-20 rounded-lg p-3">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Username Field -->
                        <div>
                            <label for="username" class="form-label">Username</label>
                            <input 
                                id="username" 
                                class="form-input" 
                                type="text" 
                                name="username" 
                                value="{{ old('username') }}" 
                                required 
                                autofocus 
                                autocomplete="username"
                                placeholder="Enter your username"
                            />
                            @error('username')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password Field -->
                        <div>
                            <label for="password" class="form-label">Password</label>
                            <input 
                                id="password" 
                                class="form-input"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password"
                                placeholder="Enter your password"
                            />
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="flex items-center mt-3">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="remember-checkbox rounded focus:ring-white focus:ring-opacity-50" 
                                name="remember"
                            >
                            <label for="remember_me" class="remember-label ml-2">
                                Remember me
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-center  pt-2">
                            <button type="submit" class="login-button w-1/2">
                                Log In
                            </button>
                        </div>
                        
                        <!-- Forgot Password Link -->
                        @if (Route::has('password.request'))
                            <div class="text-center mt-3 pb-2">
                                <a class="text-white text-sm hover:underline font-medium transition-all duration-200" href="{{ route('password.request') }}">
                                    Forgot your password?
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>