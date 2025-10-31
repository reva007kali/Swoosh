    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 glass-effect lg:px-10">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-semibold flex gap-x-2 items-center">
                    <img class="w-[50px] " src="image/swooshico.png" alt="">
                    <h1 class="italic text-white">Swoosh</h1>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="hover:text-blue-500 transition">Home</a>
                    <a href="/#about" class="hover:text-blue-500 transition">About</a>
                    <a href="/#services" class="hover:text-blue-500 transition">Services</a>
                    <a href="/#cafe" class="hover:text-blue-500 transition">Cafe</a>
                    <a href="/#facilities" class="hover:text-blue-500 transition">Facilities</a>
                    <a href="/#testimonials" class="hover:text-blue-500 transition">Testimonials</a>
                    <a href="/#contact" class="hover:text-blue-500 transition">Contact</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="/login"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition">Login</a>
                    <div id="userAvatar"
                        class="hidden w-10 h-10 bg-blue-600 rounded-full items-center justify-center cursor-pointer hover:bg-blue-700 transition">
                        <span class="text-sm font-bold">JD</span>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="md:hidden text-2xl">☰</button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden mt-4 pb-4">
                <a href="/" class="block py-2 hover:text-blue-500 transition">Home</a>
                <a href="/#about" class="block py-2 hover:text-blue-500 transition">About</a>
                <a href="/#services" class="block py-2 hover:text-blue-500 transition">Services</a>
                <a href="/#cafe" class="block py-2 hover:text-blue-500 transition">Cafe</a>
                <a href="/#facilities" class="block py-2 hover:text-blue-500 transition">Facilities</a>
                <a href="/#testimonials" class="block py-2 hover:text-blue-500 transition">Testimonials</a>
                <a href="/#contact" class="block py-2 hover:text-blue-500 transition">Contact</a>
                <a href="/login"
                    class="w-full mt-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg transition">Login</a>
            </div>
        </div>
    </nav>
