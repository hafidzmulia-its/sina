<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sina') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .font-comfortaa {
                font-family: 'Comfortaa', sans-serif;
            }
            
            .login-container {
                max-width: 1200px;
                height: 600px;
            }
            
            .login-card {
                background-color: #46798E;
                backdrop-filter: blur(10px);
            }
            
            .login-title {
                font-weight: 500;
                font-family: 'Comfortaa', sans-serif;
                line-height: 1;
            }
            
            .form-input {
                background: rgba(255, 255, 255, 0.9);
                border: none;
                border-radius: 25px;
                padding: 8px 20px;
                font-family: 'Comfortaa', sans-serif;
                font-size: 16px;
                width: 100%;
                outline: none;
                transition: all 0.3s ease;
            }
            
            .form-input:focus {
                background: white;
                box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
            }
            
            .form-input::placeholder {
                color: rgba(107, 114, 128, 0.7);
            }
            
            .form-label {
                color: white;
                font-family: 'Comfortaa', sans-serif;
                font-weight: 500;
                font-size: 18px;
                margin-bottom: 8px;
                display: block;
            }
            
            .login-button {
                background: rgba(255, 255, 255, 0.2);
                border: 2px solid white;
                border-radius: 25px;
                color: white;
                padding: 8px 20px;
                font-family: 'Comfortaa', sans-serif;
                font-size: 18px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 0.5rem; /* Reduced top margin */
            }
            
            .login-button:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: translateY(-2px);
            }
            
            .star {
                width: 20px;
                height: 20px;
            }
            
            .star-white {
                color: white;
            }
            
            .star-pink {
                color: #ff9999;
            }
            
            .star-purple {
                color: #cc99ff;
            }
            
            .error-message {
                color: #ffcdd2;
                font-size: 14px;
                margin-top: 5px;
                font-family: 'Comfortaa', sans-serif;
            }
            
            .remember-checkbox {
                margin-right: 8px;
                background-color: transparent;
                border-color: white;
            }
            
            .remember-checkbox:checked {
                background-color: white;
                border-color: white;
            }
            
            .remember-label {
                color: white;
                font-size: 14px;
                font-family: 'Comfortaa', sans-serif;
            }

            @media (max-width: 768px) {
                .login-container {
                    height: auto;
                    min-height: 100vh;
                }
                
                .login-title {
                    font-size: 64px;
                }
                
                .login-card {
                    width: 90%;
                    margin: 2rem auto;
                    position: relative !important;
                    right: auto !important;
                    top: auto !important;
                    transform: none !important;
                    padding-bottom: 3rem !important; /* Extra padding for mobile */
                }
            }
        </style>
    </head>
    <body class="font-comfortaa text-gray-900 antialiased bg-nav min-h-screen">
        {{ $slot }}
    </body>
</html>