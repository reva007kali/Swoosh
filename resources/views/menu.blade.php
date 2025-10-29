<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Swoosh Carwash — Clean. Shine. Drive.</title>

    <link rel="icon" href="/image/swooshico.png" sizes="any">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e3a8a">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="/public/image/swooshico.png">



    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jura:wght@300..700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.js"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @fluxAppearance --}}
    <style>
        body {
            font-family: Jura;
        }

        .font-roboto {
            font-family: Roboto;
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-effect {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #3b82f6 !important;
        }

        .swiper-pagination-bullet-active {
            background: #3b82f6 !important;
        }
    </style>
</head>

<body class="antialiased font-sans bg-zinc-950 text-white">

    <x-navbar></x-navbar>



    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6 bg-slate-900 min-h-screen pt-26 lg:px-20">


        @foreach ($caffeMenus as $menu)
            {{-- menu card --}}
            <div
                class="group relative bg-slate-800/60 backdrop-blur-xl border border-slate-700 
    rounded-2xl overflow-hidden shadow-md hover:shadow-blue-500/20 transition-all duration-300 hover:scale-[1.02]">

                {{-- Gambar Menu --}}
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('storage/'. $menu->image) }}" alt="{{ $menu->name }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/30 to-transparent">
                    </div>
                </div>

                {{-- Konten --}}
                <div class="p-5 flex flex-col justify-between h-full">
                    <div>
                        <h3 class="text-xl font-semibold text-white mb-1">{{ $menu->name }}</h3>
                        <p class="text-slate-400 text-sm line-clamp-2">{{ $menu->description }}</p>
                        <br>
                        <div class="space-x-3 space-y-2">
                            <span class="text-lg font-bold text-blue-400">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </span>

                            <span
                                class="px-3 py-1 text-xs font-semibold uppercase tracking-wide rounded-full
                {{ $menu->category === 'food' ? 'bg-green-600/30 text-green-300' : 'bg-blue-600/30 text-blue-300' }}">
                                {{ ucfirst($menu->category) }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach

        {{-- menu card --}}


    </div>




    <x-footer></x-footer>

</body>

</html>
