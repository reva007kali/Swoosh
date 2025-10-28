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



    <x-hero></x-hero>

    <!-- Promotional Banner -->
    <section class="py-4 bg-gradient-to-r from-blue-600 to-blue-800">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p class="text-lg md:text-xl font-bold">GRAND OPENING SPECIAL! 30% OFF on All Nano Coating Services |
                    Valid Until Dec 2025</p>
            </div>
        </div>
    </section>

    <x-about></x-about>

    <!-- Services Section -->
    <section id="services" class="py-20 lg:px-10 bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">Swoosh Carwash</h2>
                <p class="text-gray-400 text-lg">Premium Protection for Your Premium Vehicle</p>
            </div>

            <div class="">
                <div class="grid md:grid-cols-3 gap-8 items-center mx-auto">

                    <!-- Service 1 -->
                    @foreach ($services as $service)
                        <div class="">
                            <div class="glass-effect rounded-2xl overflow-hidden h-full hover:border-blue-500">
                                <div
                                    class="bg-gradient-to-br from-blue-600 overflow-hidden to-blue-800 h-52 flex items-center justify-center">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-2xl font-bold mb-2 text-blue-400">{{ $service->name }}</h3>
                                    <p class="text-gray-400 mb-4">{{ $service->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-3xl font-bold font-roboto text-white italic">IDR
                                            {{ number_format($service->price, 0, ',', '.') }}</span>
                                        <a href="#booking"
                                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition">Book</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

    <!-- Cafe Section -->
    <section id="cafe" class="py-20 lg:px-10 bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="glass-effect overflow-hidden rounded-2xl">
                    <img src="image/caffe.jpg" alt="">
                </div>
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-6">Swoosh Cafe</h2>
                    <h3 class="text-2xl font-semibold text-blue-400 mb-4">Relax While We Care for Your Car</h3>
                    <p class="text-gray-300 mb-4 leading-relaxed">Why wait in your car when you can enjoy premium
                        coffee and snacks in our comfortable, air-conditioned cafe? Swoosh Cafe offers a perfect blend
                        of comfort and convenience while our experts work their magic on your vehicle.</p>
                    <p class="text-gray-300 mb-6 leading-relaxed">Our cafe features:</p>
                    <ul class="space-y-3 text-gray-300">
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">✓</span>
                            <span>Premium coffee, tea, and specialty beverages</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">✓</span>
                            <span>Fresh pastries and light meals</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">✓</span>
                            <span>Comfortable seating with full air conditioning</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">✓</span>
                            <span>Free high-speed Wi-Fi for work or entertainment</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-500 mr-2">✓</span>
                            <span>Live viewing of your car detailing process</span>
                        </li>
                    </ul>
                    <button
                        class="mt-6 px-8 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg transition transform hover:scale-105">View
                        Menu</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section id="facilities" class="py-20 lg:px-10 bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">Facilities</h2>
                <p class="text-gray-400 text-lg">Comfort and Convenience at Every Step</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="glass-effect p-6 rounded-xl hover:border-blue-500 transition transform hover:scale-105">
                    <div class="text-4xl mb-4">☕</div>
                    <h3 class="text-xl font-bold mb-2 text-blue-400">Swoosh Cafe</h3>
                    <p class="text-gray-400">Fully air-conditioned waiting lounge with premium cafe service</p>
                </div>
                <div class="glass-effect p-6 rounded-xl hover:border-blue-500 transition transform hover:scale-105">
                    <div class="text-4xl mb-4">🚬</div>
                    <h3 class="text-xl font-bold mb-2 text-blue-400">Smoking Room</h3>
                    <p class="text-gray-400">Dedicated smoking area with proper ventilation system</p>
                </div>
                <div class="glass-effect p-6 rounded-xl hover:border-blue-500 transition transform hover:scale-105">
                    <div class="text-4xl mb-4">🎮</div>
                    <h3 class="text-xl font-bold mb-2 text-blue-400">Playground</h3>
                    <p class="text-gray-400">Safe and fun play area to keep your children entertained</p>
                </div>
                <div class="glass-effect p-6 rounded-xl hover:border-blue-500 transition transform hover:scale-105">
                    <div class="text-4xl mb-4">🕌</div>
                    <h3 class="text-xl font-bold mb-2 text-blue-400">Musholla</h3>
                    <p class="text-gray-400">Clean and comfortable prayer room for your spiritual needs</p>
                </div>
                <div class="glass-effect p-6 rounded-xl hover:border-blue-500 transition transform hover:scale-105">
                    <div class="text-4xl mb-4">📶</div>
                    <h3 class="text-xl font-bold mb-2 text-blue-400">High-Speed Wi-Fi</h3>
                    <p class="text-gray-400">Complimentary fast internet access throughout the facility</p>
                </div>
                <div class="glass-effect p-6 rounded-xl hover:border-blue-500 transition transform hover:scale-105">
                    <div class="text-4xl mb-4">🅿️</div>
                    <h3 class="text-xl font-bold mb-2 text-blue-400">Ample Parking</h3>
                    <p class="text-gray-400">Spacious parking area with security and easy access</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 lg:px-10 bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">What Our Clients Say</h2>
                <p class="text-gray-400 text-lg">Real Reviews from Real Customers</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass-effect p-6 rounded-xl">
                    <div class="flex mb-4">
                        <span class="text-yellow-500">★★★★★</span>
                    </div>
                    <p class="text-gray-300 mb-4 italic">"The best car wash I've ever experienced! The nano coating
                        service made my car look brand new. Plus, the cafe is amazing - I actually enjoyed waiting!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                            <span class="font-bold">AR</span>
                        </div>
                        <div>
                            <p class="font-semibold">Ahmad Rizki</p>
                            <p class="text-sm text-gray-400">Mercedes Owner</p>
                        </div>
                    </div>
                </div>
                <div class="glass-effect p-6 rounded-xl">
                    <div class="flex mb-4">
                        <span class="text-yellow-500">★★★★★</span>
                    </div>
                    <p class="text-gray-300 mb-4 italic">"Professional service with attention to detail. The facilities
                        are top-notch, especially the kids' playground. My family loves coming here!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                            <span class="font-bold">SP</span>
                        </div>
                        <div>
                            <p class="font-semibold">Siti Permata</p>
                            <p class="text-sm text-gray-400">BMW Owner</p>
                        </div>
                    </div>
                </div>
                <div class="glass-effect p-6 rounded-xl">
                    <div class="flex mb-4">
                        <span class="text-yellow-500">★★★★★</span>
                    </div>
                    <p class="text-gray-300 mb-4 italic">"Outstanding results! The ceramic coating has kept my car
                        looking pristine for months. Worth every rupiah. Highly recommended!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                            <span class="font-bold">BW</span>
                        </div>
                        <div>
                            <p class="font-semibold">Budi Wijaya</p>
                            <p class="text-sm text-gray-400">Audi Owner</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="py-20 bg-gray-900">
        <div class="container mx-auto px-4 max-w-3xl">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">Book Your Service</h2>
                <p class="text-gray-400 text-lg">Fill in the form below to schedule your appointment</p>
            </div>
            <form class="glass-effect p-8 rounded-2xl space-y-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-blue-400">Full Name *</label>
                        <input type="text" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition"
                            placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-blue-400">Email Address *</label>
                        <input type="email" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition"
                            placeholder="john@example.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-blue-400">Address *</label>
                    <textarea required
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition"
                        rows="2" placeholder="Your complete address"></textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-blue-400">Phone Number *</label>
                        <input type="tel" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition"
                            placeholder="+62 812-3456-7890">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-blue-400">Preferred Date *</label>
                        <input type="date" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-blue-400">Car Type *</label>
                        <input type="text" required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition"
                            placeholder="Toyota Camry 2020">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-blue-400">Service Type *</label>
                        <select required
                            class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition">
                            <option value="">Select Service</option>
                            <option value="ultra-nano">Ultra Nano Coating - Rp 3,500,000</option>
                            <option value="ceramic">Nano Ceramic Coating - Rp 2,500,000</option>
                            <option value="sealant">Super Nano Sealant - Rp 1,500,000</option>
                            <option value="other">Other Services</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-blue-400">Additional Notes</label>
                    <textarea
                        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition"
                        rows="3" placeholder="Any special requests or additional information"></textarea>
                </div>

                <div class="border-t border-gray-700 pt-6">
                    <h3 class="text-xl font-bold mb-4 text-blue-400">Payment Information</h3>

                    <div class="glass-effect p-6 rounded-lg mb-6">
                        <p class="text-sm text-gray-400 mb-3">Scan the QR code below to make payment via QRIS</p>
                        <div class="bg-white p-4 rounded-lg inline-block">
                            <div class="w-48 h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500 text-center text-sm">QRIS Code<br />Placeholder</span>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-3">* 50% down payment required to confirm booking</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-blue-400">Upload Payment Proof *</label>
                        <div class="relative">
                            <input type="file" id="paymentProof" required accept="image/*" class="hidden">
                            <label for="paymentProof"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg flex items-center justify-between cursor-pointer hover:border-blue-500 transition">
                                <span class="text-gray-400" id="fileName">Choose file or drag here</span>
                                <span class="text-blue-500">📎</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Accepted formats: JPG, PNG (Max 5MB)</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <input type="checkbox" id="terms" required
                        class="mt-1 mr-3 w-4 h-4 text-blue-600 bg-gray-800 border-gray-700 rounded focus:ring-blue-500">
                    <label for="terms" class="text-sm text-gray-400">I agree to the terms and conditions and
                        understand that my booking will be confirmed after payment verification *</label>
                </div>

                <button type="submit"
                    class="w-full px-8 py-4 bg-blue-600 hover:bg-blue-700 rounded-lg text-lg font-semibold transition transform hover:scale-105">Submit
                    Booking</button>
            </form>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 lg:px-10 bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">Get In Touch</h2>
                <p class="text-gray-400 text-lg">We're here to answer your questions</p>
            </div>
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <div class="glass-effect p-8 rounded-2xl mb-6">
                        <h3 class="text-2xl font-bold mb-6 text-blue-400">Contact Information</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <span class="text-2xl mr-4">📍</span>
                                <div>
                                    <p class="font-semibold">Address</p>
                                    <p class="text-gray-400">Jl. Premium Boulevard No. 123<br />Jakarta Selatan 12345,
                                        Indonesia</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="text-2xl mr-4">📞</span>
                                <div>
                                    <p class="font-semibold">Phone</p>
                                    <p class="text-gray-400">+62 812-3456-7890</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="text-2xl mr-4">✉️</span>
                                <div>
                                    <p class="font-semibold">Email</p>
                                    <p class="text-gray-400">info@autoglow.com</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="text-2xl mr-4">🕐</span>
                                <div>
                                    <p class="font-semibold">Opening Hours</p>
                                    <p class="text-gray-400">Monday - Sunday: 08:00 - 20:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="glass-effect p-6 rounded-xl">
                        <h3 class="text-xl font-bold mb-4 text-blue-400">Follow Us</h3>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition transform hover:scale-110">
                                <span>f</span>
                            </a>
                            <a href="#"
                                class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition transform hover:scale-110">
                                <span>📷</span>
                            </a>
                            <a href="#"
                                class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition transform hover:scale-110">
                                <span>🐦</span>
                            </a>
                            <a href="#"
                                class="w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center transition transform hover:scale-110">
                                <span>in</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="glass-effect p-8 rounded-2xl">
                    <h3 class="text-2xl font-bold mb-6 text-blue-400">Send Us a Message</h3>
                    <form class="space-y-4">
                        <div>
                            <input type="text" placeholder="Your Name"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition">
                        </div>
                        <div>
                            <input type="email" placeholder="Your Email"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition">
                        </div>
                        <div>
                            <input type="text" placeholder="Subject"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition">
                        </div>
                        <div>
                            <textarea placeholder="Your Message" rows="4"
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg focus:border-blue-500 focus:outline-none transition"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full px-8 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition transform hover:scale-105">Send
                            Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-950 lg:px-10 py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold gradient-text mb-4">Swoosh Carwash
                    </h3>
                    <p class="text-gray-400 mb-4">Premium car wash and detailing service with state-of-the-art
                        facilities.</p>
                    <div class="flex space-x-3">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition">f</a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition">📷</a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-full flex items-center justify-center transition">🐦</a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4 text-blue-400">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#about" class="hover:text-blue-500 transition">About Us</a></li>
                        <li><a href="#services" class="hover:text-blue-500 transition">Services</a></li>
                        <li><a href="#cafe" class="hover:text-blue-500 transition">Cafe</a></li>
                        <li><a href="#facilities" class="hover:text-blue-500 transition">Facilities</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4 text-blue-400">Services</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#services" class="hover:text-blue-500 transition">Ultra Nano Coating</a></li>
                        <li><a href="#services" class="hover:text-blue-500 transition">Ceramic Coating</a></li>
                        <li><a href="#services" class="hover:text-blue-500 transition">Nano Sealant</a></li>
                        <li><a href="#booking" class="hover:text-blue-500 transition">Book Now</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4 text-blue-400">Newsletter</h4>
                    <p class="text-gray-400 mb-4">Subscribe to get special offers and updates</p>
                    <form class="flex">
                        <input type="email" placeholder="Your email"
                            class="flex-1 px-4 py-2 bg-gray-800 border border-gray-700 rounded-l-lg focus:border-blue-500 focus:outline-none">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-r-lg transition">→</button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Swoosh Carwash. All rights reserved.</p>
                <div class="mt-2">
                    <a href="#" class="hover:text-blue-500 transition mx-2">Privacy Policy</a>
                    <span>|</span>
                    <a href="#" class="hover:text-blue-500 transition mx-2">Terms of Service</a>
                    <span>|</span>
                    <a href="#" class="hover:text-blue-500 transition mx-2">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollTop"
        class="fixed bottom-8 right-8 w-12 h-12 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center text-2xl shadow-lg transition transform hover:scale-110 opacity-0 pointer-events-none">
        ↑
    </button>

</body>

</html>
