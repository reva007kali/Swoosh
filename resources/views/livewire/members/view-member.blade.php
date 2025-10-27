<div
    class="space-y-8 p-4 md:p-8 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">


    <!-- Profil Member -->
    <div
        class="flex flex-col md:flex-row gap-6 items-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300">
        <img src="{{ $this->member->user && $this->member->user->image ? asset('storage/' . $this->member->user->image) : asset('image/user.png') }}"
            alt="Member Photo" class="w-28 h-28 object-cover rounded-full border-2 border-gray-300 dark:border-gray-600">

        <div class="flex-1">
            <h2 class="text-3xl font-bold mb-1">{{ $member->name }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ $member->email }} | {{ $member->phone }}</p>
            <p class="text-md font-medium">Saldo: <span class="text-green-500">Rp
                    {{ number_format($member->balance, 0, ',', '.') }}</span> | Point: <span
                    class="text-yellow-400">{{ $member->member_point }}</span></p>
        </div>

        <div class="flex flex-col items-center space-y-4">
            <div class="w-30 h-30 bg-white rounded-lg flex items-center justify-center">
                {!! $qrCodeSvg !!}
            </div>
        </div>
    </div>


    <div x-data="{ open: false }" class="relative">
        {{-- Tombol untuk buka modal --}}
        <button @click="open = true"
            class="mt-5 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
            Lihat & Cetak Kartu
        </button>

        {{-- Modal Fullscreen --}}
        <div x-show="open" x-transition
            class="fixed inset-0 bg-white/90 flex items-center justify-center z-50 print:bg-white print:static print:flex print:items-center print:justify-center">
            {{-- Tombol Close (tidak tampil saat print) --}}
            <button @click="open = false"
                class="absolute top-5 right-5 font-extrabold text-black text-xl hover:text-gray-300 transition print:hidden">
                ✕
            </button>

            {{-- Tombol Print --}}
            <button onclick="window.print()"
                class="absolute top-5 left-5 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition print:hidden">
                Print / Save
            </button>

            {{-- Kartu Member --}}
            <div class="printable scale-[2] lg:scale-[2.3] transform origin-center">
                <div class="memberCard w-[300px] relative overflow-hidden">
                    <img class="rounded-xl w-full object-cover" src="/image/kartumember.png" alt="">
                    <div class="absolute top-9 right-3 z-3 text-right">
                        <h1 class="text-yellow-500">{{ $member->name }}</h1>
                        @if ($member->vehicles->isNotEmpty())
                            <h1 class="text-yellow-500 text-sm">
                                {{ $member->vehicles->first()->plate_number }}
                            </h1>
                        @endif
                    </div>
                    <div
                        class="w-17 h-17 absolute bottom-11 left-[20px] bg-white  rounded-lg overflow-hidden flex items-center justify-center">
                        {!! $qrCodeSvg !!}
                    </div>
                    <div class="text-[8px] text-white absolute bottom-4 left-[36px]">
                        {{ $member->created_at->format('d/m/y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Style khusus print --}}
    <style>
        @media print {

            /* Sembunyikan semua elemen kecuali kartu */
            body * {
                visibility: hidden !important;
            }

            .printable,
            .printable * {
                visibility: visible !important;
            }

            /* Atur posisi kartu di tengah halaman */
            .printable {
                position: absolute !important;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) !important;
                scale: 1 !important;
            }

            .printable .memberCard {
                margin-top: 0rem;
                scale: 2;
            }


            /* Pastikan gambar tidak pecah di tengah halaman */
            .printable img {
                page-break-inside: avoid;
                width: 100%;
                height: auto;
            }

            /* Hilangkan margin printer */
            @page {
                size: A4;
                margin: 0;
            }
        }
    </style>




    {{-- member card --}}
    <div class="lg:flex space-y-5 gap-6">
        <div class="w-[300px] relative overflow-hidden">
            <img class="rounded-xl w-full object-cover" src="/image/kartumember.png" alt="">
            <div class="absolute top-9 right-3 z-3 text-right">
                <h1 class="text-yellow-500">{{ $member->name }}</h1>
                @if ($member->vehicles->isNotEmpty())
                    <h1 class="text-yellow-500 text-sm">
                        {{ $member->vehicles->first()->plate_number }}
                    </h1>
                @endif
            </div>
            <div
                class="w-17 h-17 absolute bottom-11 left-[20px] bg-white  rounded-lg overflow-hidden flex items-center justify-center">
                {!! $qrCodeSvg !!}
            </div>
            <div class="text-[8px] absolute bottom-4 left-[36px]">
                {{ $member->created_at->format('d/m/y') }}
            </div>
        </div>
    </div>
    {{-- member card --}}

    <!-- Kendaraan -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300">
        <h3 class="font-bold text-xl mb-4">Kendaraan</h3>

        @if ($member->vehicles->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">Belum ada kendaraan terdaftar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <th class="p-3 text-left">Nama</th>
                            <th class="p-3 text-left">Nomor Polisi</th>
                            <th class="p-3 text-left">Tipe</th>
                            <th class="p-3 text-left">Warna</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member->vehicles as $vehicle)
                            <tr
                                class="border-t border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                <td class="p-3">{{ $vehicle->name }}</td>
                                <td class="p-3">{{ $vehicle->plate_number }}</td>
                                <td class="p-3">{{ ucfirst($vehicle->type ?? '-') }}</td>
                                <td class="p-3">{{ $vehicle->color ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>


    <!-- Top Up -->
    @if (auth()->user()->role->name !== 'member')
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300">
            <h3 class="font-bold text-xl mb-4">Top Up Saldo</h3>
            <form wire:submit.prevent="topUp" class="flex flex-col md:flex-row gap-3">
                <input type="number" wire:model="amount" placeholder="Jumlah top up"
                    class="border p-2 rounded w-full md:w-1/3 dark:bg-gray-700 dark:border-gray-600">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors duration-200">Top
                    Up</button>
            </form>
        </div>
    @endif

    <!-- Transaksi -->
    @if (auth()->user()->role->name !== 'member')
        <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300">
            <h3 class="font-bold text-xl mb-4">Transaksi</h3>
            <form wire:submit.prevent="makeTransaction" class="flex flex-col gap-3">
                <div class="flex flex-col md:flex-row gap-4 flex-wrap">

                    <!-- Service -->
                    <div class="flex flex-col flex-1">
                        <label class="mb-1 font-medium">Layanan</label>
                        <select wire:model="service_id"
                            class="border p-2 rounded dark:bg-gray-700 dark:border-gray-600">
                            <option value="">Pilih layanan</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }} - Rp
                                    {{ number_format($service->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Vehicle -->
                    <div class="flex flex-col flex-1">
                        <label class="mb-1 font-medium">Kendaraan</label>
                        <div class="flex gap-2">
                            <select wire:model="vehicle_id"
                                class="border p-2 rounded dark:bg-gray-700 dark:border-gray-600 flex-1">
                                <option value="">Pilih kendaraan</option>
                                @foreach ($member->vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }} |
                                        {{ $vehicle->plate_number }}</option>
                                @endforeach
                            </select>

                            <!-- Tombol tambah kendaraan -->
                            <button wire:click="$toggle('showAddVehicle')"
                                class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600 transition">
                                + Tambah
                            </button>

                        </div>
                    </div>

                    <!-- Modal Livewire -->

                    @if ($showAddVehicle)
                        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-md shadow-lg">
                                <h3 class="text-lg font-bold mb-4">Tambah Kendaraan</h3>

                                <div class="space-y-3">
                                    <input type="text" wire:model.defer="newVehicle.plate_number"
                                        placeholder="Nomor Polisi"
                                        class="w-full border p-2 rounded dark:bg-gray-700 dark:border-gray-600">
                                    <input type="text" wire:model.defer="newVehicle.type" placeholder="Tipe"
                                        class="w-full border p-2 rounded dark:bg-gray-700 dark:border-gray-600">
                                    <input type="text" wire:model.defer="newVehicle.color" placeholder="Warna"
                                        class="w-full border p-2 rounded dark:bg-gray-700 dark:border-gray-600">
                                </div>

                                <div class="mt-4 flex justify-end gap-2">
                                    <button wire:click="$set('showAddVehicle', false)"
                                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded">Batal</button>
                                    <button wire:click="addVehicle"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
                                </div>
                            </div>
                        </div>
                    @endif


                    <!-- Quantity -->
                    <div class="flex flex-col w-24">
                        <label class="mb-1 font-medium">Qty</label>
                        <input type="number" wire:model="quantity" min="1"
                            class="border p-2 rounded dark:bg-gray-700 dark:border-gray-600" placeholder="Jumlah">
                    </div>

                    <!-- Payment Method -->
                    <div class="flex flex-col w-36">
                        <label class="mb-1 font-medium">Payment</label>
                        <select wire:model="payment_method_id"
                            class="border p-2 rounded dark:bg-gray-700 dark:border-gray-600">
                            <option value="">Pilih Payment</option>
                            @foreach ($paymentMethods as $pm)
                                <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Discount -->
                    <div class="flex flex-col w-28">
                        <label class="mb-1 font-medium">Diskon</label>
                        <input type="number" wire:model="discount" min="0"
                            class="border p-2 rounded dark:bg-gray-700 dark:border-gray-600" placeholder="Rp">
                    </div>

                    <!-- Tax -->
                    <div class="flex flex-col w-28">
                        <label class="mb-1 font-medium">Pajak</label>
                        <input type="number" wire:model="tax" min="0"
                            class="border p-2 rounded dark:bg-gray-700 dark:border-gray-600" placeholder="Rp">
                    </div>

                    <!-- Submit -->
                    <div class="flex flex-col justify-end">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 text-white px-4 py-2 rounded transition-colors duration-200">
                            Bayar
                        </button>
                    </div>

                </div>
            </form>
        </div>
    @endif

    <!-- 5 Transaksi Terakhir -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300 overflow-x-auto">
        <h3 class="font-bold text-xl mb-4">5 Transaksi Terakhir</h3>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Service</th>
                    <th class="border p-2">Kendaraan</th>
                    <th class="border p-2">Qty</th>
                    <th class="border p-2">Grand Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestTransactions as $trans)
                    @foreach ($trans->items as $item)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="border p-2">{{ $trans->created_at->format('d-m-Y') }}</td>
                            <td class="border p-2">{{ $item->service->name ?? 'Service tidak ditemukan' }}</td>
                            <td class="border p-2">{{ $trans->vehicle->plate_number }}</td>
                            <td class="border p-2">{{ $item->quantity }}</td>
                            <td class="border p-2">Rp {{ number_format($trans->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5" class="border p-2 text-center text-gray-500 dark:text-gray-400">Belum ada
                            transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
