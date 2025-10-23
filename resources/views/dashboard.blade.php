<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sina') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=East+Sea+Dokdo&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .font-east-sea-dokdo {
                font-family: 'East Sea Dokdo', cursive;
            }
            
            .dashboard-card {
                border-radius: 30px;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                overflow: hidden;
                position: relative;
                max-width: 1000px;
                margin: 0 auto;
            }
            
            .background-image {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: 1;
            }
            
            .content-overlay {
                position: relative;
                z-index: 10;
                padding: 3rem;
                min-height: 400px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            
            .story-title {
                font-size: 6rem;
                line-height: 0.9;
                margin-bottom: 1.5rem;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            .title-main {
                color: #247E2B;
                font-weight: bold;
                transform: rotate(-2deg);
                display: inline-block;
                margin-right: 0.5rem;
            }
            
            .title-sub {
                color: #DD610E;
                font-weight: bold;
                transform: rotate(1deg);
                display: inline-block;
            }
            
            .story-synopsis {
                color: #374151;
                font-size: 1rem;
                line-height: 1.6;
                margin-bottom: 2rem;
                max-width: 500px;
                font-family: 'Inter', sans-serif;
            }
            
            .read-button {
                background: #a7c4a0;
                color: #2d5016;
                border: none;
                border-radius: 9999px;
                padding: 12px 0 12px 0;
                font-family: 'Comfortaa', sans-serif;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: all 0.3s ease;
                align-self: flex-start;
                box-shadow: 0 4px 12px rgba(167, 196, 160, 0.4);
            }
            
            .read-button:hover {
                background: #95b88e;
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(167, 196, 160, 0.6);
            }

            /* History Section Styles */
            .history-carousel {
                display: flex;
                gap: 1rem;
                overflow-x: auto;
                padding: 1rem 0;
                scroll-behavior: smooth;
            }

            .history-card {
                flex: none;
                /* width: 120px; */
                background: white;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s;
            }

            .history-card:hover {
                transform: translateY(-4px);
            }

            .history-card img {
                width: 100%;
                height: 160px;
                object-fit: cover;
            }

            .history-card-content {
                padding: 0.75rem;
            }

            .history-card-title {
                font-size: 0.75rem;
                font-weight: 600;
                color: #374151;
                margin-bottom: 0.25rem;
                line-height: 1.2;
            }

            .history-progress {
                font-size: 0.625rem;
                color: #6b7280;
            }

            /* Book Types Section */
            .book-types {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1.5rem;
                margin-top: 2rem;
            }

            .book-type-card {
                position: relative;
                border-radius: 24px;
                overflow: hidden;
                height: 200px;
                cursor: pointer;
                transition: transform 0.3s ease;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            }

            .book-type-card:hover {
                transform: translateY(-8px);
            }

            .book-type-image {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: 1;
            }

            .book-type-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
                color: white;
                padding: 2rem 1.5rem 1.5rem;
                z-index: 10;
            }

            .book-type-title {
                font-size: 2rem;
                font-weight: bold;
                font-family: 'East Sea Dokdo', cursive;
                margin-bottom: 0.25rem;
            }

            .book-type-count {
                font-size: 0.875rem;
                opacity: 0.9;
            }

            @media (max-width: 768px) {
                .content-overlay {
                    padding: 2rem 1.5rem;
                    min-height: 350px;
                }
                
                .story-title {
                    font-size: 3rem;
                }
                
                .story-synopsis {
                    font-size: 0.9rem;
                    margin-bottom: 1.5rem;
                }

                .book-types {
                    grid-template-columns: 1fr;
                }
            }
            
            @media (max-width: 480px) {
                .story-title {
                    font-size: 2.5rem;
                }
                
                .content-overlay {
                    padding: 1.5rem 1rem;
                    min-height: 300px;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-nav">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="py-8 px-4 sm:px-6 lg:px-8">
                <!-- Featured Story Card -->
                <div class="dashboard-card mb-12">
                    <!-- Background Image -->
                    <img 
                        src="{{ asset('images/landingpage.png') }}" 
                        alt="Story Background" 
                        class="background-image"
                    />
                    
                    <!-- Content Overlay -->
                    <div class="content-overlay">
                        <!-- Story Title -->
                        <h1 class="story-title font-east-sea-dokdo">
                            <span class="title-main">KURA-KURA</span><br>
                            <span class="text-[#303A3A]">&</span>
                            <span class="title-sub"> KELINCI</span>
                        </h1>
                        
                        <!-- Story Synopsis -->
                        <p class="story-synopsis">
                            Kelinci mengejek seekor kura-kura yang berjalan 
                            lambat, membuat sang kura-kura membalas dengan 
                            tantangan untuk berlomba dengan sang kelinci. 
                            Walaupun awalnya sang kelinci berlari jauh sekali dari 
                            hadapan sang kura-kura dan amat yakin akan menang, 
                            namun kura-kura tidak pernah menyerah.
                        </p>
                        
                        <!-- Read Button -->
                        <button class="read-button lg:w-1/3 w-full" onclick="startReading({{ $featuredBook->id ?? 1 }})">
                            Baca Sekarang
                        </button>
                    </div>
                </div>

                
            </main>
        </div>
        <!-- Recent Reading History -->
        <div class="p-8">
                @if($recentHistory->count() > 0)
                <section class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 font-fredoka">Terakhir dibaca</h2>
                    <div class="history-carousel">
                        @foreach($recentHistory as $history)
                        <div class="history-card w-64" onclick="continueReading({{ $history->buku_id }})">
                            <img 
                                src="{{ $history->buku->cover ? asset( $history->buku->cover) : asset('images/signup.png') }}" 
                                alt="{{ $history->buku->judul }}"
                            />
                            <div class="history-card-content">
                                <h3 class="history-card-title">{{ Str::limit($history->buku->judul, 20) }}</h3>
                                <p class="history-progress">{{ $history->getProgressPercentage() }}% selesai</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- Book Types Section -->
                <section>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 font-comfortaa">Telusuri berbagai jenis cerita lainnya!</h2>
                    <div class="book-types">
                        @foreach($bookTypes as $type)
                        <div class="book-type-card" onclick="exploreType('{{ $type->jenis }}')">
                            <!-- Use existing signup.png as fallback or create solid color backgrounds -->
                            @php
                                $typeImages = [
                                    'Fabel' => 'images/Fabel.png', // Use existing image temporarily
                                    'Cerita Rakyat' => 'images/ceritarakyat.png', // Use existing image temporarily
                                    'Dongeng' => 'images/Dongeng.png' // Use existing image temporarily
                                ];
                                $bgImage = $typeImages[$type->jenis] ?? 'images/signup.png';
                            @endphp
                            <img 
                                src="{{ asset($bgImage) }}" 
                                alt="{{ $type->jenis }}" 
                                class="book-type-image"
                                onerror="this.style.display='none'; this.parentElement.style.background='linear-gradient(135deg, #{{ $type->jenis === 'Fabel' ? '10b981' : ($type->jenis === 'Cerita Rakyat' ? '3b82f6' : 'f59e0b') }}, #{{ $type->jenis === 'Fabel' ? '065f46' : ($type->jenis === 'Cerita Rakyat' ? '1e40af' : 'd97706') }})'"
                            />
                            <div class="book-type-overlay">
                                <h3 class="book-type-title">{{ $type->jenis }}</h3>
                                <p class="book-type-count">{{ $type->count }} cerita tersedia</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
        </div>
        <script>
            function startReading(bookId) {
                // Redirect to book detail or reading page
                window.location.href = `/buku/${bookId}`;
            }

            function continueReading(bookId) {
                // Continue reading from last position
                window.location.href = `/buku/${bookId}/read`;
            }

            function exploreType(jenis) {
                // Navigate to book list filtered by type
                window.location.href = `/buku?jenis=${encodeURIComponent(jenis)}`;
            }
        </script>
    </body>
</html>