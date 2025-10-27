<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Swoosh Carwash — Clean. Shine. Drive.</title>

    <link rel="icon" href="/image/swooshico.png" sizes="any">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    
    <style>
        /* Heading font */
        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: "Poppins", "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        /* Body fallback */
        body {
            font-family: "Inter", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        /* Subtle motion for floating shapes */
        @keyframes floaty {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-8px) rotate(3deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .floaty {
            animation: floaty 6s ease-in-out infinite;
        }

        /* small tweak for dark focus outlines */
        :focus {
            outline: none;
        }

        /* subtle glass panel on very dark background */
        .glass {
            background: rgba(17, 24, 39, 0.6);
            /* neutral-900/60 */
            backdrop-filter: blur(6px);
        }
    </style>
</head>

<body class="antialiased bg-gray-900 text-gray-100">
    <div class="min-h-screen">

        <!-- Navbar -->
        <nav id="site-nav"
            class="fixed top-4 left-0 right-0 z-50 mx-auto max-w-7xl px-5 py-3 rounded-2xl glass border border-gray-800 shadow-lg transition-all">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="#" class="inline-flex items-center space-x-3">
                        <div
                            class="w-11 h-11 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow">
                            <img src="/image/swooshico.png" alt="Swoosh" class="w-7 h-7 object-contain" />
                        </div>
                        <div>
                            <h1
                                class="text-xl md:text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-300">
                                Swoosh Carwash</h1>
                            <p class="text-xs text-gray-400 -mt-1">Professional Car Care</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-sm font-medium text-gray-300 hover:text-blue-300 transition">Home</a>
                    <a href="#about" class="text-sm font-medium text-gray-300 hover:text-blue-300 transition">About</a>
                    <a href="#services"
                        class="text-sm font-medium text-gray-300 hover:text-blue-300 transition">Services</a>
                    <a href="#facilities"
                        class="text-sm font-medium text-gray-300 hover:text-blue-300 transition">Facilities</a>
                    <a href="#reservation"
                        class="text-sm font-medium text-gray-300 hover:text-blue-300 transition">Book</a>
                    <a href="#contact"
                        class="text-sm font-medium text-gray-300 hover:text-blue-300 transition">Contact</a>
                </div>

                <div class="flex items-center space-x-3">
                    @auth
                        <div class="hidden md:flex items-center space-x-3">
                            <img src="{{ Auth::user()->image_url }}"
                                class="w-9 h-9 rounded-full border-2 border-blue-500 object-cover" alt="avatar" />
                            <span class="text-sm font-medium text-gray-200">{{ Auth::user()->name }}</span>

                            @if (in_array(Auth::user()->role->name, ['admin', 'cashier']))
                                <a href="{{ route('dashboard') }}"
                                    class="ml-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg text-sm font-semibold hover:shadow-xl transform hover:-translate-y-0.5">
                                    Dashboard
                                </a>
                            @elseif (Auth::user()->role->name === 'member')
                                @php
                                    $member = \App\Models\Member::where('user_id', Auth::id())->first();
                                @endphp
                                @if ($member && $member->qr_code)
                                    <a href="{{ route('members.view', ['qr_code' => $member->qr_code]) }}"
                                        class="ml-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg text-sm font-semibold hover:shadow-xl transform hover:-translate-y-0.5">
                                        Profile
                                    </a>
                                @endif
                            @endif
                        </div>
                    @else
                        <div class="hidden md:flex items-center space-x-2">
                            <a href="{{ route('login') }}"
                                class="text-sm font-medium text-gray-300 hover:text-blue-300 transition">Login</a>
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg text-sm font-semibold hover:shadow-xl transition">Register</a>
                        </div>
                    @endauth

                    <!-- Mobile menu button -->
                    <button id="nav-toggle" aria-controls="mobile-menu" aria-expanded="false"
                        class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-800 border border-gray-700 shadow-sm hover:scale-105 transition">
                        <svg id="nav-open" class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="nav-close" class="w-6 h-6 text-gray-200 hidden" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="mt-3 hidden md:hidden">
                <div class="grid gap-2 bg-gray-800 rounded-lg p-3 border border-gray-700">
                    <a href="#home" class="block px-3 py-2 rounded-lg text-gray-200 hover:bg-gray-700">Home</a>
                    <a href="#about" class="block px-3 py-2 rounded-lg text-gray-200 hover:bg-gray-700">About</a>
                    <a href="#services" class="block px-3 py-2 rounded-lg text-gray-200 hover:bg-gray-700">Services</a>
                    <a href="#facilities"
                        class="block px-3 py-2 rounded-lg text-gray-200 hover:bg-gray-700">Facilities</a>
                    <a href="#reservation" class="block px-3 py-2 rounded-lg text-gray-200 hover:bg-gray-700">Book</a>
                    <a href="#contact" class="block px-3 py-2 rounded-lg text-gray-200 hover:bg-gray-700">Contact</a>
                </div>
            </div>
        </nav>

        <!-- Hero -->
        <header id="home" class="relative pt-28 pb-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid md:grid-cols-2 gap-10 items-center">
                    <div>
                        <div
                            class="inline-flex items-center gap-3 px-3 py-2 rounded-full mb-6 bg-gradient-to-r from-gray-800/60 to-gray-900/50 border border-gray-700">
                            <svg class="w-4 h-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.164c.969 0 1.371 1.24.588 1.81l-3.37 2.452a1 1 0 00-.364 1.118l1.287 3.95c.3.921-.755 1.688-1.54 1.118l-3.37-2.452a1 1 0 00-1.176 0l-3.37 2.452c-.784.57-1.84-.197-1.54-1.118l1.287-3.95a1 1 0 00-.364-1.118L2.09 9.377c-.783-.57-.38-1.81.588-1.81h4.164a1 1 0 00.95-.69l1.286-3.95z" />
                            </svg>
                            <span class="font-medium text-gray-200">Premium • Eco Friendly • Fast</span>
                        </div>

                        <h2 class="text-4xl md:text-5xl font-bold leading-tight text-white mb-4">
                            Clean. Shine. Drive with
                            <span
                                class="bg-clip-text text-transparent bg-gradient-to-r from-blue-300 to-indigo-200">Confidence</span>
                        </h2>

                        <p class="text-lg text-gray-300 mb-8 max-w-xl">
                            Swoosh Carwash blends speed, precision, and premium care. From quick washes to full
                            detailing, we've got your ride covered — plus a comfy Swoosh Caffe while you wait.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <a href="#reservation"
                                class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full font-semibold shadow-2xl hover:scale-105 transition transform">
                                Book Now
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>

                            <a href="#services"
                                class="inline-flex items-center gap-3 px-6 py-3 border border-gray-700 text-blue-200 rounded-full font-semibold hover:bg-gray-800 transition">
                                Our Services
                            </a>

                            <div
                                class="inline-flex items-center gap-3 px-4 py-3 rounded-full text-sm text-gray-300 bg-gray-800 border border-gray-700">
                                <svg class="w-5 h-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M2 11a1 1 0 011-1h4l1-2h4l1 2h4a1 1 0 011 1v4a1 1 0 01-1 1h-4l-1 2H8l-1-2H3a1 1 0 01-1-1v-4z" />
                                </svg>
                                <span class="text-xs">Express Lane Available</span>
                            </div>
                        </div>

                        <div class="mt-8 grid grid-cols-3 gap-3 max-w-md">
                            <div
                                class="flex items-center gap-3 bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-700">
                                <div
                                    class="w-10 h-10 rounded-md bg-gradient-to-br from-blue-700 to-indigo-600 flex items-center justify-center text-white">
                                    ⭑</div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-200">Quality</div>
                                    <div class="text-xs text-gray-400">Eco products</div>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-3 bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-700">
                                <div
                                    class="w-10 h-10 rounded-md bg-gradient-to-br from-green-500 to-teal-400 flex items-center justify-center text-white">
                                    ⚡</div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-200">Fast</div>
                                    <div class="text-xs text-gray-400">Quick turnaround</div>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-3 bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-700">
                                <div
                                    class="w-10 h-10 rounded-md bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white">
                                    ☕</div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-200">Relax</div>
                                    <div class="text-xs text-gray-400">Swoosh Caffe</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <!-- floating sporty shapes -->
                        <div
                            class="absolute -right-6 -top-6 w-36 h-36 rounded-full bg-gradient-to-br from-blue-700 to-indigo-600 opacity-60 blur-2xl floaty">
                        </div>
                        <div
                            class="absolute -left-10 -bottom-10 w-44 h-44 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 opacity-25 blur-3xl floaty">
                        </div>

                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-gray-800">
                            <img src="/image/hero.jpg" alt="Carwash Hero"
                                class="w-full object-cover transform hover:scale-105 transition-transform duration-500" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div
                                class="absolute bottom-6 left-6 bg-gradient-to-r from-gray-800/80 to-gray-900/70 px-4 py-2 rounded-full shadow-md text-sm font-semibold text-gray-100 border border-gray-700">
                                Sports Shine Package — from <span class="text-blue-300">IDR 150k</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- About -->
        <section id="about" class="py-16 px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div
                    class="inline-block px-4 py-2 bg-gradient-to-r from-gray-800 to-gray-900 text-blue-300 rounded-full text-sm font-semibold mb-4 border border-gray-700">
                    About Us</div>
                <h3 class="text-3xl md:text-4xl font-bold text-white mb-4">We make your car look and feel new</h3>
                <p class="text-lg text-gray-300 leading-relaxed">Swoosh Carwash is committed to delivering premium
                    car care using eco-friendly solutions, professional technicians, and a focus on speed and
                    convenience.
                    Relax at Swoosh Caffe while your car gets the spa treatment.</p>
            </div>
        </section>

        <!-- Services -->
        <section id="services" class="py-16 bg-gray-900 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <div
                            class="inline-block px-4 py-2 bg-gradient-to-r from-gray-800 to-gray-900 text-blue-300 rounded-full text-sm font-semibold mb-3 border border-gray-700">
                            Services</div>
                        <h3 class="text-3xl md:text-4xl font-bold text-white">Our Services</h3>
                        <p class="text-gray-400 mt-2">Engineered for performance and protection.</p>
                    </div>
                    <div class="text-sm text-gray-400">Select a package that fits your ride</div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($services as $service)
                        <div
                            class="group relative bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow hover:shadow-xl transition transform hover:-translate-y-2">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white text-lg shadow-md">
                                    <img src="{{ $service->image }}" alt="service" class="w-8 h-8 object-contain" />
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-white">{{ $service->name }}</h4>
                                    <p class="text-sm text-gray-400 mt-1">{{ Str::limit($service->description, 110) }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-sm font-medium text-gray-200">From <span class="text-blue-300">IDR
                                        120k</span></div>
                                <a href="#reservation"
                                    class="text-xs px-3 py-2 bg-gradient-to-r from-blue-700 to-indigo-600 text-white rounded-full font-semibold hover:opacity-95 transition">Book</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Facilities -->
        <section id="facilities" class="py-16 bg-gradient-to-b from-gray-900 to-gray-900 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-10">
                    <div
                        class="inline-block px-4 py-2 bg-gradient-to-r from-gray-800 to-gray-900 text-blue-300 rounded-full text-sm font-semibold mb-4 border border-gray-700">
                        Facilities</div>
                    <h3 class="text-3xl md:text-4xl font-bold text-white mb-2">Modern amenities for your comfort</h3>
                    <p class="text-gray-400">Comfortable lounge, free WiFi, and secure parking.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-gray-800 rounded-2xl p-6 shadow hover:shadow-xl transition border border-gray-700">
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-700 to-indigo-600 flex items-center justify-center text-white">
                                ☕</div>
                            <h4 class="text-lg font-semibold text-white">Swoosh Caffe</h4>
                        </div>
                        <p class="text-sm text-gray-400">Premium menu, cozy seating, and a great view while you wait.
                        </p>
                    </div>

                    <div class="bg-gray-800 rounded-2xl p-6 shadow hover:shadow-xl transition border border-gray-700">
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-600 to-teal-500 flex items-center justify-center text-white">
                                📶</div>
                            <h4 class="text-lg font-semibold text-white">Free WiFi</h4>
                        </div>
                        <p class="text-sm text-gray-400">Stay productive or entertained with high-speed connectivity.
                        </p>
                    </div>

                    <div class="bg-gray-800 rounded-2xl p-6 shadow hover:shadow-xl transition border border-gray-700">
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="w-12 h-12 rounded-lg bg-gradient-to-br from-indigo-700 to-blue-600 flex items-center justify-center text-white">
                                🔒</div>
                            <h4 class="text-lg font-semibold text-white">Secure Parking</h4>
                        </div>
                        <p class="text-sm text-gray-400">Well-lit, guarded parking while your vehicle is in our care.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section id="testimonials" class="py-16 px-6 bg-gray-900">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-8">
                    <div
                        class="inline-block px-4 py-2 bg-gradient-to-r from-gray-800 to-gray-900 text-blue-300 rounded-full text-sm font-semibold mb-4 border border-gray-700">
                        Testimonials</div>
                    <h3 class="text-3xl md:text-4xl font-bold text-white">What our customers say</h3>
                    <p class="text-gray-400">Real feedback from drivers who trust Swoosh.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-gray-800 rounded-2xl p-6 shadow border border-gray-700">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-green-600 to-green-500 text-white flex items-center justify-center font-bold mr-3">
                                SA</div>
                            <div>
                                <h5 class="font-semibold text-white">Sarah Anderson</h5>
                                <p class="text-xs text-gray-400">Premium Member</p>
                            </div>
                        </div>
                        <p class="text-gray-300">"Love the Swoosh Caffe! Great coffee and the perfect place to wait.
                            The online booking system is super convenient."</p>
                    </div>

                    <div class="bg-gray-800 rounded-2xl p-6 shadow border border-gray-700">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-purple-500 text-white flex items-center justify-center font-bold mr-3">
                                MR</div>
                            <div>
                                <h5 class="font-semibold text-white">Michael Roberts</h5>
                                <p class="text-xs text-gray-400">Business Owner</p>
                            </div>
                        </div>
                        <p class="text-gray-300">"Best carwash in Jakarta! Eco-friendly products, professional team,
                            and reasonable prices. Highly recommended!"</p>
                    </div>

                    <div class="bg-gray-800 rounded-2xl p-6 shadow border border-gray-700">
                        <div class="flex items-center mb-3">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-700 to-indigo-600 text-white flex items-center justify-center font-bold mr-3">
                                AS</div>
                            <div>
                                <h5 class="font-semibold text-white">Alex Sim</h5>
                                <p class="text-xs text-gray-400">Regular</p>
                            </div>
                        </div>
                        <p class="text-gray-300">"Quick, thorough, and my car looks brand new. The staff are friendly
                            and the waiting area is great."</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Reservation -->
        <section id="reservation" class="py-16 bg-gray-900 px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <div
                        class="inline-block px-4 py-2 bg-gradient-to-r from-gray-800 to-gray-900 text-blue-300 rounded-full text-sm font-semibold mb-4 border border-gray-700">
                        Book Now</div>
                    <h3 class="text-3xl font-bold text-white mb-2">Fast online booking</h3>
                    <p class="text-gray-400">Reserve your spot in seconds — choose your package and time.</p>
                </div>

                <div
                    class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-lg p-6 md:p-8 border border-gray-700">
                    <form action="#" method="POST" class="space-y-4" novalidate>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                                <input type="text" name="name" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-700 bg-gray-800 text-gray-100 focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="Your name" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                                <input type="tel" name="phone" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-700 bg-gray-800 text-gray-100 focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="+62 xxx xxxx xxxx" />
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Vehicle Type</label>
                                <select name="vehicle_type" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-700 bg-gray-800 text-gray-100 focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="">Select vehicle type</option>
                                    <option value="sedan">Sedan</option>
                                    <option value="suv">SUV</option>
                                    <option value="mpv">MPV</option>
                                    <option value="truck">Truck</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Service Type</label>
                                <select name="service_type" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-700 bg-gray-800 text-gray-100 focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="">Select service</option>
                                    <option value="basic">Basic Wash</option>
                                    <option value="premium">Premium Wash</option>
                                    <option value="detailing">Full Detailing</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Preferred Date</label>
                                <input type="date" name="date" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-700 bg-gray-800 text-gray-100 focus:ring-2 focus:ring-blue-500 outline-none" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Preferred Time</label>
                                <input type="time" name="time" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-700 bg-gray-800 text-gray-100 focus:ring-2 focus:ring-blue-500 outline-none" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Additional Notes
                                (Optional)</label>
                            <textarea name="notes" rows="4"
                                class="w-full px-4 py-3 rounded-lg border border-gray-700 bg-gray-800 text-gray-100 focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                                placeholder="Any special requests or notes..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold shadow-2xl hover:scale-105 transition transform">
                            Book Now
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="py-16 px-6 bg-gray-900">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-8">
                    <div
                        class="inline-block px-4 py-2 bg-gradient-to-r from-gray-800 to-gray-900 text-blue-300 rounded-full text-sm font-semibold mb-4 border border-gray-700">
                        Get In Touch</div>
                    <h3 class="text-3xl font-bold text-white mb-2">Contact Us</h3>
                    <p class="text-gray-400">We're here to help and answer any questions</p>
                </div>

                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-800 rounded-2xl p-6 shadow border border-gray-700 text-center">
                        <div
                            class="w-14 h-14 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 mx-auto flex items-center justify-center text-white mb-4">
                            📞</div>
                        <h4 class="font-semibold text-white">Phone</h4>
                        <p class="text-sm text-gray-400">+62 123 4567 890</p>
                        <p class="text-sm text-gray-400">Mon-Sun: 8AM - 8PM</p>
                    </div>

                    <div class="bg-gray-800 rounded-2xl p-6 shadow border border-gray-700 text-center">
                        <div
                            class="w-14 h-14 rounded-lg bg-gradient-to-br from-green-500 to-teal-400 mx-auto flex items-center justify-center text-white mb-4">
                            ✉️</div>
                        <h4 class="font-semibold text-white">Email</h4>
                        <p class="text-sm text-gray-400">info@swooshcarwash.com</p>
                        <p class="text-sm text-gray-400">support@swooshcarwash.com</p>
                    </div>

                    <div class="bg-gray-800 rounded-2xl p-6 shadow border border-gray-700 text-center">
                        <div
                            class="w-14 h-14 rounded-lg bg-gradient-to-br from-purple-600 to-pink-500 mx-auto flex items-center justify-center text-white mb-4">
                            📍</div>
                        <h4 class="font-semibold text-white">Location</h4>
                        <p class="text-sm text-gray-400">Jakarta, Indonesia</p>
                        <p class="text-sm text-gray-400">Easy access parking</p>
                    </div>
                </div>

                <div class="text-center">
                    <iframe src="https://maps.google.com/maps?q=Jakarta&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        class="w-full h-56 rounded-2xl border-0 shadow-lg" loading="lazy"></iframe>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer
            class="py-12 px-6 bg-gradient-to-r from-gray-900 via-indigo-900 to-gray-900 text-gray-300 mt-12 border-t border-gray-800">
            <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white font-bold">
                            S</div>
                        <div>
                            <h4 class="font-bold text-lg text-white">Swoosh Carwash</h4>
                            <p class="text-sm text-gray-400">Clean. Shine. Drive happy.</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500">© 2025 Swoosh Carwash. All rights reserved. Made with ❤️ in
                        Jakarta</p>
                </div>

                <div>
                    <h4 class="font-semibold mb-3 text-white">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#services" class="hover:text-blue-300">Services</a></li>
                        <li><a href="#reservation" class="hover:text-blue-300">Book Now</a></li>
                        <li><a href="#facilities" class="hover:text-blue-300">Facilities</a></li>
                        <li><a href="#contact" class="hover:text-blue-300">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-3 text-white">Follow Us</h4>
                    <div class="flex items-center gap-3 mb-4">
                        <a class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center hover:bg-blue-600 transition"
                            href="#"><svg class="w-5 h-5 text-gray-200" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg></a>
                        <a class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center hover:bg-blue-600 transition"
                            href="#"><svg class="w-5 h-5 text-gray-200" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z" />
                            </svg></a>
                        <a class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center hover:bg-blue-600 transition"
                            href="#"><svg class="w-5 h-5 text-gray-200" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg></a>
                    </div>
                    <p class="text-sm text-gray-400">Questions? Call us at <span class="font-semibold text-white">+62
                            123 4567 890</span></p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Small JS: mobile toggle + header scroll shadow -->
    <script>
        (function() {
            const navToggle = document.getElementById('nav-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const navOpen = document.getElementById('nav-open');
            const navClose = document.getElementById('nav-close');
            const siteNav = document.getElementById('site-nav');

            navToggle?.addEventListener('click', function() {
                const isHidden = mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden', !isHidden);
                navOpen.classList.toggle('hidden', !isHidden);
                navClose.classList.toggle('hidden', isHidden);
                navToggle.setAttribute('aria-expanded', String(isHidden));
            });

            // shadow and color tweak on scroll
            window.addEventListener('scroll', function() {
                if (window.scrollY > 30) {
                    siteNav.classList.add('shadow-2xl');
                    siteNav.classList.remove('glass');
                    siteNav.style.background = 'rgba(10, 14, 22, 0.85)';
                } else {
                    siteNav.classList.remove('shadow-2xl');
                    siteNav.classList.add('glass');
                    siteNav.style.background = '';
                }
            });
        })();
    </script>
</body>

</html>
