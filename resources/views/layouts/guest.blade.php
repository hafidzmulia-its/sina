
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
            /* Reset for register page only */
            body.register-page {
                margin: 0;
                padding: 0;
            }
            
            .font-comfortaa {
                font-family: 'Comfortaa', sans-serif;
            }
            
            /* LOGIN STYLES (existing) */
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
                margin-top: 0.5rem;
            }
            
            .login-button:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: translateY(-2px);
            }
            
            /* REGISTER STYLES (new) */
            .register-container {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                margin: 0;
                padding: 0;
            }
            
            .register-container .absolute.top-0.right-0 {
                position: fixed;
                top: 0;
                right: 0;
                width: 60%;
                height: 100vh;
                z-index: 1;
            }
            
            .register-container .absolute.top-0.right-0 img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }
            
            /* .register-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            } */
            
            .register-title {
              
                font-family: 'Comfortaa', sans-serif;
                font-weight: 600;
            }
            
            .register-label {
                color: #374151;
                font-family: 'Comfortaa', sans-serif;
                font-weight: 500;
                font-size: 14px;
                margin-bottom: 6px;
                display: block;
            }
            
            .register-input {
                background: white;
                border: 1px solid #d1d5db;
                border-radius: 9999px;
                padding: 10px 16px;
                font-family: 'Comfortaa', sans-serif;
                font-size: 14px;
                width: 100%;
                outline: none;
                transition: all 0.3s ease;
            }
            
            .register-input:focus {
                border-color: #0d9488;
                box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
            }
            
            .register-input::placeholder {
                color: #9ca3af;
            }
            
            .role-selection {
                display: flex;
                gap: 16px;
                justify-content: center;
            }
            
            .role-option {
                cursor: pointer;
            }
            
            .role-radio {
                display: none;
            }
            
            .role-card {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 16px;
                border: 2px solid #e5e7eb;
                border-radius: 16px;
                transition: all 0.3s ease;
                background: white;
            }
            
            .role-radio:checked + .role-card {
                border-color: #0d9488;
                background: rgba(13, 148, 136, 0.05);
            }
            
            .role-avatar {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                margin-bottom: 8px;
            }
            
            .role-text {
                font-family: 'Comfortaa', sans-serif;
                font-weight: 500;
                color: #374151;
                font-size: 14px;
            }
            
            .register-button {
                background: #0d9488;
                color: white;
                border: none;
                border-radius: 25px;
                padding: 12px 32px;
                font-family: 'Comfortaa', sans-serif;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .register-button:hover {
                background: #0f766e;
                transform: translateY(-2px);
            }
            
            .login-link {
                color: #6b7280;
                font-family: 'Comfortaa', sans-serif;
                text-decoration: none;
                font-size: 14px;
            }
            
            .login-link span {
                color: #0d9488;
            }
            
            .error-message-register {
                color: #ef4444;
                font-size: 12px;
                margin-top: 4px;
                font-family: 'Comfortaa', sans-serif;
            }
            
            .child-username-field {
                margin-top: 16px;
            }
            
            /* Other existing styles... */
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
                    padding-bottom: 3rem !important;
                }
                
                /* Register mobile styles */
                .register-container .absolute.top-0.right-0 {
                    position: fixed;
                    width: 100%;
                    height: 100vh;
                }
                
                .register-card {
                    width: 90%;
                    margin: 2rem auto;
                    position: relative !important;
                    left: auto !important;
                    top: auto !important;
                    transform: none !important;
                }
                
                .role-selection {
                    flex-direction: column;
                    gap: 12px;
                }
                
                .role-card {
                    flex-direction: row;
                    padding: 12px;
                }
                
                .role-avatar {
                    width: 40px;
                    height: 40px;
                    margin-right: 12px;
                    margin-bottom: 0;
                }
            }
        </style>
    </head>
    <body class="font-comfortaa text-gray-900 antialiased bg-nav min-h-screen">
        {{ $slot }}
    </body>
</html>