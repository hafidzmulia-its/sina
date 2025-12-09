<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sina — Selamat Datang</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logobuku.png') }}">
  <link rel="shortcut icon" href="{{ asset('images/logobuku.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('images/logobuku.png') }}">
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Fredoka:wght@300..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  {{-- Vite entry points (adjust if your filenames differ) --}}
  @if(app()->environment('production'))
    {!! vite_assets() !!}
  @else
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
</head>
<body class="antialiased">
  {{-- Full-screen background --}}
  <div
    class="min-h-screen bg-cover "
    style="background-image: url('{{ asset('images/openwebsite.png') }}')"
  >
    {{-- semi-transparent overlay to make text readable --}}
    <div class="min-h-screen ">
      {{-- top bar with logo --}}
      <!-- <header class="container mx-auto px-6 py-6">
        <a href="{{ url('/') }}" aria-label="Sina home" class="inline-block">
          <img src="{{ asset('images/logo_sina.png') }}" alt="Sina logo" class="h-10 md:h-12" />
        </a>
      </header> -->

      {{-- main hero content --}}
      <main class="flex items-center justify-center md:justify-end min-h-[calc(100vh-6rem)] px-4 sm:px-6">
        <div class="w-full md:w-3/4 lg:w-3/5 text-center md:text-right md:pr-6 lg:pr-12 xl:pr-20">
          <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-[#F6E4D4] text-shadow leading-tight font-comfortaa">
            Dunia imajinasi adalah tempat bermain yang <span class="hidden md:inline"><br></span> luar biasa!
          </h1>

          <p class="mt-4 text-white/90 text-xl sm:text-2xl md:text-3xl lg:text-4xl mx-auto md:mr-0 font-fredoka">
          Mulailah membaca dan temukan awal dari <span class="hidden md:inline"><br></span> sebuah kisah hebat yang belum terungkap.
          </p>

          <div class="mt-8 flex flex-col items-center gap-3 md:items-end">
            {{-- Primary button -> register --}}
            <a
              href="{{ route('register') }}"
              class="inline-flex items-center font-inter text-sm sm:text-xl md:text-2xl justify-center w-1/3 sm:w-2/3 md:w-1/2 lg:w-1/4 py-1 md:py-3 rounded-full bg-white text-sky-700 font-semibold shadow-md hover:shadow-lg transition-transform duration-150 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-sky-300"
              aria-label="Buat akun"
            >
              Buat Akun
            </a>
            
            {{-- Small login prompt --}}
            <a href="{{ route('login') }}" class="text-base sm:text-lg md:text-xl text-white/80 hover:text-white">
              Sudah mempunyai akun?
              <span class="ml-1 font-semibold underline">Login</span>
            </a>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
