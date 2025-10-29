  <!-- Services Section -->
  <section id="services" class="py-20 lg:px-10 bg-gray-900">
      <div class="container mx-auto px-4">
          <div class="text-center mb-12">
              <h2 class="text-4xl md:text-5xl font-bold gradient-text mb-4">Swoosh Carwash</h2>
              <p class="text-gray-400 text-lg">Premium Protection for Your Premium Vehicle</p>
          </div>

          <div class="">
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                  @foreach ($services as $service)
                      <div
                          class="group relative bg-gradient-to-br from-slate-800/70 to-slate-900/60 rounded-2xl border border-slate-700/50 backdrop-blur-md shadow-xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-blue-500/30">

                          {{-- Gambar Service --}}
                          <div class="relative overflow-hidden h-52 flex items-center justify-center bg-slate-900/50">
                              <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}"
                                  class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                              <div
                                  class="absolute inset-0 bg-gradient-to-t from-slate-900/90 to-transparent opacity-70 group-hover:opacity-60 transition-opacity duration-300">
                              </div>
                              <span
                                  class="absolute top-3 left-3 bg-blue-600/80 text-white text-xs px-3 py-1 rounded-full tracking-wide uppercase">
                                  {{ $service->category ?? 'Service' }}
                              </span>
                          </div>

                          {{-- Konten --}}
                          <div class="p-6 space-y-3">
                              <h3
                                  class="text-xl font-semibold text-white tracking-wide group-hover:text-blue-400 transition-colors">
                                  {{ $service->name }}
                              </h3>

                              <p class="text-gray-400 text-sm leading-relaxed line-clamp-3">
                                  {{ $service->description }}
                              </p>

                              <div class="flex justify-between items-center pt-3">
                                  <span class="text-2xl font-bold text-blue-400 drop-shadow">
                                      Rp {{ number_format($service->price, 0, ',', '.') }}
                                  </span>
                              </div>
                          </div>

                          {{-- Glow effect --}}
                          <div
                              class="absolute inset-0 pointer-events-none rounded-2xl ring-1 ring-transparent group-hover:ring-blue-500/40 transition duration-500">
                          </div>
                      </div>
                  @endforeach
              </div>

          </div>
      </div>
  </section>
