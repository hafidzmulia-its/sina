<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sina') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logobuku.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/logobuku.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/logobuku.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=East+Sea+Dokdo&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Carousel Script - Load Immediately -->
        <script>
            // FORCE IMMEDIATE GLOBAL FUNCTION AVAILABILITY
            console.log('=== CAROUSEL SCRIPT LOADING ===');
            
            // Global carousel state
            window.carouselData = {
                history: {
                    currentIndex: 0,
                    totalCards: 0
                },
                recommendations: {
                    currentIndex: 0,
                    totalCards: 0
                }
            };

            // Helper function to get carousel measurements
            window.getCarouselMeasurements = function(carouselId) {
                const carousel = document.getElementById(carouselId);
                const cards = carousel.querySelectorAll('.uniform-card');
                
                if (!carousel || cards.length === 0) {
                    return { cardTotalWidth: 280, visibleCards: 1, containerWidth: 300 }; // fallback
                }
                
                const firstCard = cards[0];
                const containerWidth = carousel.parentElement.offsetWidth;
                
                // Get actual card dimensions
                const cardRect = firstCard.getBoundingClientRect();
                const cardWidth = cardRect.width;
                
                // Get gap from computed styles
                const computedStyle = window.getComputedStyle(carousel);
                let gapPx = 24; // default fallback for 1.5rem
                
                if (computedStyle.gap && computedStyle.gap !== 'normal') {
                    // Convert rem/px to pixels
                    if (computedStyle.gap.includes('rem')) {
                        const remValue = parseFloat(computedStyle.gap);
                        const fontSize = parseFloat(window.getComputedStyle(document.documentElement).fontSize);
                        gapPx = remValue * fontSize;
                    } else {
                        gapPx = parseFloat(computedStyle.gap) || 24;
                    }
                }
                
                const cardTotalWidth = cardWidth + gapPx;
                const visibleCards = Math.max(1, Math.floor(containerWidth / cardTotalWidth));
                
                return {
                    cardTotalWidth,
                    visibleCards,
                    containerWidth,
                    cardWidth,
                    gapPx
                };
            };

            // Define ALL functions on window object IMMEDIATELY
            window.startReading = function(bookId) {
                window.location.href = `/buku/${bookId}`;
            };

            window.continueReading = function(bookId) {
                window.location.href = `/buku/${bookId}/read`;
            };

            window.showBook = function(bookId) {
                window.location.href = `/buku/${bookId}`;
            };

            window.exploreType = function(jenis) {
                window.location.href = `/buku?jenis=${encodeURIComponent(jenis)}`;
            };

            // Generic carousel slide function
            window.slideCarousel = function(carouselType, direction) {
                console.log(`=== ${carouselType.toUpperCase()} CAROUSEL SLIDE ===`, direction);
                
                const carouselId = carouselType + 'Carousel';
                const carousel = document.getElementById(carouselId);
                if (!carousel) {
                    console.error('Carousel element not found!', carouselId);
                    return;
                }
                
                const cards = carousel.querySelectorAll('.uniform-card');
                if (cards.length === 0) {
                    console.error('No cards found!');
                    return;
                }
                
                const measurements = window.getCarouselMeasurements(carouselId);
                const maxIndex = Math.max(0, window.carouselData[carouselType].totalCards - measurements.visibleCards);
                
                if (direction === 'next' && window.carouselData[carouselType].currentIndex < maxIndex) {
                    window.carouselData[carouselType].currentIndex++;
                } else if (direction === 'prev' && window.carouselData[carouselType].currentIndex > 0) {
                    window.carouselData[carouselType].currentIndex--;
                }
                
                const translateX = -(window.carouselData[carouselType].currentIndex * measurements.cardTotalWidth);
                carousel.style.transform = `translateX(${translateX}px)`;
                window.updateCarouselButtons(carouselType);
            };

            // Wrapper functions for backward compatibility
            window.slideHistoryCarousel = function(direction) {
                window.slideCarousel('history', direction);
            };

            window.slideRecommendationsCarousel = function(direction) {
                window.slideCarousel('recommendations', direction);
            };

            // Generic carousel button update function
            window.updateCarouselButtons = function(carouselType) {
                const prevButton = document.getElementById(carouselType + 'Prev');
                const nextButton = document.getElementById(carouselType + 'Next');
                const carousel = document.getElementById(carouselType + 'Carousel');
                
                if (!carousel || !prevButton || !nextButton) {
                    console.log('Missing carousel elements for', carouselType);
                    return;
                }
                
                const cards = carousel.querySelectorAll('.uniform-card');
                if (cards.length === 0) {
                    console.log('No cards to update buttons');
                    return;
                }
                
                const measurements = window.getCarouselMeasurements(carouselType + 'Carousel');
                const maxIndex = Math.max(0, window.carouselData[carouselType].totalCards - measurements.visibleCards);
                
                const isPrevDisabled = window.carouselData[carouselType].currentIndex <= 0;
                const isNextDisabled = window.carouselData[carouselType].currentIndex >= maxIndex || 
                                     window.carouselData[carouselType].totalCards <= measurements.visibleCards;
                
                prevButton.disabled = isPrevDisabled;
                nextButton.disabled = isNextDisabled;
                
                prevButton.style.opacity = isPrevDisabled ? '0.3' : '1';
                prevButton.style.pointerEvents = isPrevDisabled ? 'none' : 'auto';
                
                nextButton.style.opacity = isNextDisabled ? '0.3' : '1';
                nextButton.style.pointerEvents = isNextDisabled ? 'none' : 'auto';
            };
            
            // VERIFY FUNCTIONS ARE AVAILABLE
            console.log('slideHistoryCarousel available:', typeof window.slideHistoryCarousel);
            console.log('=== ALL CAROUSEL FUNCTIONS LOADED ===');
        </script>
        
        <style>
            .font-east-sea-dokdo {
                font-family: 'East Sea Dokdo', cursive;
            }
            
            .dashboard-card {
                border-radius: 30px;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                overflow: hidden;
                position: relative;
                width: 95%;
                height: auto;
                min-height: 60vh;
                margin: 0 auto;
            }
            
            @media (min-width: 640px) {
                .dashboard-card {
                    width: 90%;
                    min-height: 70vh;
                }
            }
            
            @media (min-width: 1024px) {
                .dashboard-card {
                    width: 80%;
                    height: 80vh;
                    min-height: auto;
                }
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
                padding: 8% 6%;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            
            @media (min-width: 640px) {
                .content-overlay {
                    padding: 7% 7%;
                }
            }
            
            @media (min-width: 1024px) {
                .content-overlay {
                    padding: 6% 8%;
                }
            }
            
            .story-title {
                font-size: clamp(2.5rem, 8vw, 9rem);
                line-height: 0.95;
                margin-bottom: 4%;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            @media (min-width: 640px) {
                .story-title {
                    font-size: clamp(3.5rem, 10vw, 9rem);
                    line-height: 0.9;
                    margin-bottom: 3%;
                }
            }
            
            .title-main {
                color: #247E2B;
                font-weight: medium;
                transform: rotate(-2deg);
                display: inline-block;
                margin-right: 0.5rem;
            }
            
            .title-sub {
                color: #DD610E;
                font-weight: medium;
                transform: rotate(1deg);
                display: inline-block;
            }
            
            .story-synopsis {
                color: #374151;
                font-size: clamp(0.875rem, 2.5vw, 1.25rem);
                line-height: 1.6;
                margin-bottom: 6%;
                max-width: 90%;
                font-family: 'Inter', sans-serif;
            }
            
            @media (min-width: 640px) {
                .story-synopsis {
                    max-width: 70%;
                    margin-bottom: 5%;
                }
            }
            
            @media (min-width: 1024px) {
                .story-synopsis {
                    max-width: 45%;
                    font-size: clamp(1rem, 1.5vw, 1.25rem);
                }
            }
            
            .read-button {
                background: #a7c4a0;
                color: #2d5016;
                border: none;
                border-radius: 9999px;
                padding: 3% 0;
                width: 70%;
                font-family: 'Comfortaa', sans-serif;
                font-weight: 600;
                font-size: clamp(0.875rem, 2.5vw, 1rem);
                cursor: pointer;
                transition: all 0.3s ease;
                align-self: flex-start;
                box-shadow: 0 4px 12px rgba(167, 196, 160, 0.4);
            }
            
            @media (min-width: 640px) {
                .read-button {
                    width: 50%;
                    padding: 2.5% 0;
                }
            }
            
            @media (min-width: 1024px) {
                .read-button {
                    width: 35%;
                    padding: 1.5% 0;
                    font-size: clamp(0.875rem, 1.1vw, 1rem);
                }
            }
            
            .read-button:hover {
                background: #95b88e;
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(167, 196, 160, 0.6);
            }

            /* History Section Styles */
            .history-carousel-container {
                position: relative;
                overflow: visible;
                padding: 0 50px;
            }
            
            @media (max-width: 768px) {
                .history-carousel-container {
                    padding: 0 40px;
                }
            }
            
            @media (max-width: 480px) {
                .history-carousel-container {
                    padding: 0 35px;
                }
            }
            
            .history-carousel {
                display: flex;
                gap: 2.75rem;
                overflow: visible; /* Changed from hidden to visible */
                padding: 1rem 0;
                scroll-behavior: smooth;
                transition: transform 0.5s ease;
                width: 100%; /* Ensure full width */
            }
            
            .carousel-nav-button {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                background: rgba(255, 255, 255, 0.9);
                border: 2px solid #e5e7eb;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                z-index: 20;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
            
            @media (min-width: 640px) {
                .carousel-nav-button {
                    width: 48px;
                    height: 48px;
                }
            }
            
            .carousel-nav-button:hover {
                background: white;
                border-color: #0d9488;
                transform: translateY(-50%) scale(1.1);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            }
            
            .carousel-nav-button:disabled {
                opacity: 0.3 !important;
                cursor: not-allowed;
                transform: translateY(-50%);
                pointer-events: none;
                background: rgba(255, 255, 255, 0.5) !important;
                border-color: #d1d5db !important;
            }
            
            .carousel-nav-button:disabled:hover {
                transform: translateY(-50%);
                background: rgba(255, 255, 255, 0.5) !important;
                border-color: #d1d5db !important;
            }
            
            .carousel-nav-button:disabled svg {
                color: #9ca3af !important;
            }
            
            .carousel-prev {
                left: 10px; /* Moved closer to center */
            }
            
            .carousel-next {
                right: 10px; /* Moved closer to center */
            }
            
            .carousel-nav-button svg {
                width: 20px;
                height: 20px;
                color: #374151;
            }
            
            .carousel-nav-button:hover svg {
                color: #0d9488;
            }

            /* Uniform Card Styles for both History and Recommendations */
            .uniform-card {
                flex: none;
                border-radius: 16px;
                transition: all 0.3s ease;
                cursor: pointer;
                width: 13rem;
            }
            
            @media (min-width: 640px) {
                .uniform-card {
                    width: 14rem;
                }
            }
            
            @media (min-width: 1024px) {
                .uniform-card {
                    width: 16rem;
                }
            }

            .uniform-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.2);
            }

            .uniform-card img {
                width: 100%;
                aspect-ratio: 488 / 724;
                object-fit: cover;
                border-radius: 0;
                display: block;
            }

            .uniform-card-content {
                padding: 0.75rem;
            }

            .uniform-card-title {
                font-size: 0.875rem;
                font-weight: 600;
                color: #374151;
                margin-bottom: 0.25rem;
                line-height: 1.2;
            }

            .uniform-card-subtitle {
                font-size: 0.75rem;
                color: #6b7280;
            }

            .uniform-card-meta {
                font-size: 0.75rem;
                color: #0d9488;
                font-weight: 500;
            }

            /* Book Types Section */
            .book-types {
                display: grid;
                grid-template-columns: 1fr;
                gap: 1.5rem;
                margin-top: 2rem;
                padding: 0 1rem;
                justify-items: center;
            }
            
            @media (min-width: 640px) {
                .book-types {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 1.75rem;
                    padding: 0 1.5rem;
                }
            }
            
            @media (min-width: 1024px) {
                .book-types {
                    grid-template-columns: repeat(3, 1fr);
                    gap: 2rem;
                    padding: 0 2rem;
                }
            }

            .book-type-card {
                position: relative;
                overflow: hidden;
                aspect-ratio: 1 / 1;
                width: 90%;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            @media (min-width: 640px) {
                .book-type-card {
                    width: 85%;
                }
            }
            
            @media (min-width: 1024px) {
                .book-type-card {
                    width: 80%;
                }
            }

            .book-type-card:hover {
                transform: translateY(-8px) scale(1.02);
                /* box-shadow: 0 12px 35px -8px rgba(0, 0, 0, 0.25); */
            }

            .book-type-image {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: 1;
                transition: transform 0.3s ease;
            }

            .book-type-card:hover .book-type-image {
                transform: scale(1.05);
            }

            .book-type-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                /* background: linear-gradient(transparent, rgba(0, 0, 0, 0.8)); */
                /* color: white; */
                padding: 2.5rem 2rem 2rem;
                z-index: 10;
                transition: all 0.3s ease;
            }

            .book-type-title {
                font-size: 2.25rem;
                font-weight: bold;
                font-family: 'East Sea Dokdo', cursive;
                margin-bottom: 0.5rem;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }

            .book-type-count {
                font-size: 0.95rem;
                opacity: 0.95;
                font-weight: 500;
            }

            @media (max-width: 768px) {
                .content-overlay {
                    padding: 6% 5%;
                }
                
                .story-synopsis {
                    max-width: 85%;
                }

                .read-button {
                    width: 60%;
                }

                .book-types {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                    padding: 0 1rem;
                }

                .book-type-title {
                    font-size: 1.875rem;
                }

                .book-type-overlay {
                    padding: 1.75rem 1.5rem 1.75rem;
                }
                
                .carousel-container {
                    padding: 0 45px;
                }
            }
            
            @media (max-width: 480px) {
                .content-overlay {
                    padding: 5% 4%;
                }
                
                .story-synopsis {
                    max-width: 95%;
                    font-size: 0.875rem;
                }

                .read-button {
                    width: 75%;
                    padding: 4% 0;
                    font-size: 0.875rem;
                }

                .book-types {
                    grid-template-columns: 1fr;
                    gap: 1.25rem;
                    margin-top: 1.5rem;
                    padding: 0 0.5rem;
                }

                .book-type-title {
                    font-size: 1.5rem;
                }

                .book-type-count {
                    font-size: 0.8rem;
                }
                
                .book-type-overlay {
                    padding: 1.5rem 1.25rem;
                }
                
                .carousel-container {
                    padding: 0 35px;
                }
                
                .carousel-nav-button {
                    width: 36px;
                    height: 36px;
                }
                
                .carousel-nav-button svg {
                    width: 16px;
                    height: 16px;
                }
            }
            
            /* Carousel Containers */
            .carousel-container {
                position: relative;
                overflow: visible;
                padding: 0 60px;
            }
            
            .carousel-track {
                display: flex;
                gap: 1.5rem;
                overflow: visible;
                padding: 1rem 0;
                scroll-behavior: smooth;
                transition: transform 0.5s ease;
                width: 100%;
            }

            /* Quote Section */
            .quote-section {
                position: relative;
            }
            
            .quote-section blockquote {
                position: relative;
                line-height: 1.4;
            }

            .quote-section blockquote::before {
                content: '"';
                font-size: 3rem;
                color: #0d9488;
                position: absolute;
                left: -1.5rem;
                top: -1rem;
                font-family: Georgia, serif;
                font-weight: bold;
            }
            
            @media (min-width: 640px) {
                .quote-section blockquote::before {
                    font-size: 4rem;
                    left: -2rem;
                    top: -1.5rem;
                }
            }
            
            @media (min-width: 1024px) {
                .quote-section blockquote::before {
                    font-size: 5rem;
                    left: -3rem;
                    top: -2rem;
                }
            }

            /* Footer */
            /* footer {
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            }

            .footer-logo-text {
                background: linear-gradient(135deg, #0d9488, #06b6d4);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            } */
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-nav">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="px-4 sm:px-6 lg:px-8 flex items-center justify-center min-h-[80vh]">
                <!-- Featured Story Card -->
                <div class="dashboard-card">
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
        <div class="p-4 sm:p-6 md:p-8 w-full sm:w-11/12 md:w-4/5 mx-auto">
                @if($recentHistory->count() > 0)
                <section class="mb-8 sm:mb-10 md:mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 font-fredoka">Terakhir dibaca</h2>
                    <div class="relative overflow-hidden">
                        <div class="carousel-container">
                            <!-- Carousel Navigation Buttons -->
                            <button class="carousel-nav-button carousel-prev" id="historyPrev" onclick="slideHistoryCarousel('prev')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            
                            <button class="carousel-nav-button carousel-next" id="historyNext" onclick="slideHistoryCarousel('next')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            
                            <div class="carousel-track" id="historyCarousel">
                                @foreach($recentHistory as $history)
                                <div class="uniform-card" onclick="showBook({{ $history->buku_id }})">
                                    <img 
                                        src="{{ $history->buku->cover ? asset( $history->buku->cover) : asset('images/signup.png') }}" 
                                        alt="{{ $history->buku->judul }}"
                                    />
                                    <div class="uniform-card-content">
                                        <h3 class="uniform-card-title">{{ Str::limit($history->buku->judul, 30) }}</h3>
                                        <p class="uniform-card-subtitle">{{ number_format($history->getProgressPercentage(), 0) }}% selesai</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Book Types Section -->
                <section>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6 font-fredoka">Telusuri berbagai jenis cerita lainnya!</h2>
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
                            <!-- <div class="book-type-overlay">
                                <h3 class="book-type-title">{{ $type->jenis }}</h3>
                                <p class="book-type-count">{{ $type->count }} cerita tersedia</p>
                            </div> -->
                        </div>
                        @endforeach
                    </div>
                </section>
        </div>

        <!-- Recommendations & Quote Section -->
        <div class="bg-gradient-to-b from-[#C7D4CE] to-[#F9FBFA] pt-12 md:pt-16">
            <div class="w-full sm:w-11/12 md:w-4/5 mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Recommendations Section -->
                <section>
                    <h2 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6 sm:mb-8 font-fredoka text-left">Kamu mungkin suka ini</h2>
                    
                    <!-- Recommended Books Carousel -->
                    @if(isset($popularBooks) && $popularBooks->count() > 0)
                    <div class="relative overflow-hidden mb-12">
                        <div class="carousel-container">
                            <!-- Carousel Navigation Buttons -->
                            <button class="carousel-nav-button carousel-prev" id="recommendationsPrev" onclick="slideRecommendationsCarousel('prev')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            
                            <button class="carousel-nav-button carousel-next" id="recommendationsNext" onclick="slideRecommendationsCarousel('next')">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            
                            <div class="carousel-track" id="recommendationsCarousel">
                                @foreach($popularBooks as $book)
                                <div class="uniform-card" onclick="showBook({{ $book->id }})">
                                    <img 
                                        src="{{ $book->cover ? asset($book->cover) : asset('images/default-book-cover.png') }}" 
                                        alt="{{ $book->judul }}"
                                    />
                                    <div class="uniform-card-content">
                                        <h3 class="uniform-card-title">{{ Str::limit($book->judul, 30) }}</h3>
                                        <p class="uniform-card-meta">{{ $book->jenis }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Quote & Footer Section with Illustration -->
                    <div class="relative min-h-64 md:min-h-96 flex flex-col justify-end">
                        <!-- Quote Section -->
                        <div class="w-full md:w-3/4 lg:w-1/2 pr-4 md:pr-8 mb-8 px-4 md:px-0">
                            <div class="quote-section">
                                <blockquote class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-comfortaa text-[#46798E] mb-4 md:mb-6 relative z-20">
                                    "Membaca memberikan manusia <span class="text-[#FF7262] font-bold">tempat untuk pergi</span> ketika mereka harus tinggal di mana mereka berada."
                                </blockquote>
                                <cite class="text-gray-500 font-inter font-medium text-base md:text-lg">-Mason Cooley</cite>
                            </div>
                        </div>
                        
                        <!-- Footer Section - Always at bottom -->
                        <div class="w-full md:w-3/4 lg:w-1/2 bg-nav rounded-tr-2xl mt-auto">
                            <footer class="p-4 sm:p-6 md:p-8 relative z-20">
                                <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                                    
                                    <!-- Logo and Brand -->
                                    <div class="flex items-center mb-2 md:mb-0">
                                        <img src="{{ asset('images/logo_sina.png') }}" alt="Sina Logo" class="h-6 sm:h-8 w-auto mr-3">
                                    </div>
                                    
                                    <!-- Credits -->
                                    <div class="text-left md:text-right">
                                        <p class="text-xs sm:text-sm text-gray-600 mb-1">
                                            Alifa Hikmawati • Rajni Yafi' Amelia Rahmah
                                        </p>
                                        <p class="text-xs sm:text-sm text-gray-600">
                                            Reinasya Diar Phalosa • Aghnia Tias Salsabila • Hafidz Mulia
                                        </p>
                                    </div>
                                </div>
                            </footer>
                        </div>
                        
                        <!-- Illustration positioned absolutely on right side (hidden on mobile) -->
                        <img 
                            src="{{ asset('images/landingpage_bawah.png') }}" 
                            alt="Reading Illustration" 
                            class="hidden md:block absolute right-0 bottom-0 w-auto h-full object-contain object-bottom z-10"
                        />
                    </div>
                </section>
            </div>
        </div>
        <script>
            // Initialize carousels when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                console.log('=== CAROUSEL INITIALIZATION ===');
                
                // Initialize history carousel
                const historyCards = document.querySelectorAll('#historyCarousel .uniform-card');
                window.carouselData.history.totalCards = historyCards.length;
                window.carouselData.history.currentIndex = 0;
                
                // Initialize recommendations carousel
                const recommendationCards = document.querySelectorAll('#recommendationsCarousel .uniform-card');
                window.carouselData.recommendations.totalCards = recommendationCards.length;
                window.carouselData.recommendations.currentIndex = 0;
                
                console.log('Found', window.carouselData.history.totalCards, 'history cards');
                console.log('Found', window.carouselData.recommendations.totalCards, 'recommendation cards');
                
                // Reset carousel positions
                const historyCarousel = document.getElementById('historyCarousel');
                const recommendationsCarousel = document.getElementById('recommendationsCarousel');
                
                if (historyCarousel) {
                    historyCarousel.style.transform = 'translateX(0px)';
                }
                
                if (recommendationsCarousel) {
                    recommendationsCarousel.style.transform = 'translateX(0px)';
                }
                
                // Set initial button states
                setTimeout(() => {
                    console.log('Setting initial button states...');
                    if (historyCards.length > 0) window.updateCarouselButtons('history');
                    if (recommendationCards.length > 0) window.updateCarouselButtons('recommendations');
                }, 100);
                
                // Handle window resize
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(() => {
                        // Reset both carousels on resize
                        window.carouselData.history.currentIndex = 0;
                        window.carouselData.recommendations.currentIndex = 0;
                        
                        if (historyCarousel) {
                            historyCarousel.style.transform = 'translateX(0px)';
                            window.updateCarouselButtons('history');
                        }
                        
                        if (recommendationsCarousel) {
                            recommendationsCarousel.style.transform = 'translateX(0px)';
                            window.updateCarouselButtons('recommendations');
                        }
                    }, 250);
                });
                
                // Add touch/swipe support for both carousels
                function addTouchSupport(carousel, slideFunction) {
                    let startX = 0;
                    let currentX = 0;
                    let isDragging = false;
                    
                    if (!carousel) return;
                    
                    carousel.addEventListener('touchstart', function(e) {
                        startX = e.touches[0].clientX;
                        isDragging = true;
                    });
                    
                    carousel.addEventListener('touchmove', function(e) {
                        if (!isDragging) return;
                        e.preventDefault();
                        currentX = e.touches[0].clientX;
                    });
                    
                    carousel.addEventListener('touchend', function(e) {
                        if (!isDragging) return;
                        isDragging = false;
                        
                        const diffX = startX - currentX;
                        const threshold = 50;
                        
                        if (Math.abs(diffX) > threshold) {
                            if (diffX > 0) {
                                slideFunction('next');
                            } else {
                                slideFunction('prev');
                            }
                        }
                    });
                }
                
                addTouchSupport(historyCarousel, window.slideHistoryCarousel);
                addTouchSupport(recommendationsCarousel, window.slideRecommendationsCarousel);
                
                console.log('=== CAROUSEL INITIALIZATION COMPLETE ===');
            });
        </script>
    </body>
</html>