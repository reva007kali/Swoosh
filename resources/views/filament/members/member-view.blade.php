<div class="space-y-6">

    <div>
        <img src="{{ $member->user && $member->user->image ? asset('storage/' . $member->user->image) : asset('image/user.png') }}"
            alt="Member Photo" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
    </div>
    <div class="border-b pb-2 border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
            {{ $member->name }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ $member->email }} | {{ $member->phone }}
        </p>
    </div>

    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-gray-500 dark:text-gray-400">Saldo</p>
            <p class="font-semibold text-gray-900 dark:text-gray-100">
                Rp{{ number_format($member->balance, 0, ',', '.') }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 dark:text-gray-400">Poin Member</p>
            <p class="font-semibold text-gray-900 dark:text-gray-100">
                {{ $member->member_point }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 dark:text-gray-400">Tanggal Bergabung</p>
            <p class="text-gray-800 dark:text-gray-200">
                {{ $member->created_at->format('d M Y') }}
            </p>
        </div>

        <div>
            <p class="text-gray-500 dark:text-gray-400">Terakhir Diperbarui</p>
            <p class="text-gray-800 dark:text-gray-200">
                {{ $member->updated_at->diffForHumans() }}
            </p>
        </div>
    </div>

    <div>
        <p class="text-gray-600 dark:text-gray-300 font-medium mb-2">Kendaraan:</p>
        @forelse($member->vehicles as $vehicle)
            <div class="p-3 border rounded-lg bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700 mb-2">
                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $vehicle->name }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    {{ $vehicle->plate_number ?? '-' }} |
                    {{ ucfirst($vehicle->type ?? '-') }} |
                    {{ $vehicle->color ?? '-' }}
                </p>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                Belum ada kendaraan terdaftar.
            </p>
        @endforelse
    </div>
    <div class="mt-6">
        <p class="text-gray-600 dark:text-gray-300 font-medium mb-2">
            Transaksi Terakhir:
        </p>

        @php
            $transactions = $member
                ->transactions()
                ->latest() // urutkan dari terbaru
                ->take(5) // ambil 5 terakhir
                ->get();
        @endphp

        @if ($transactions->isEmpty())
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                Belum ada transaksi.
            </p>
        @else
            <div class="space-y-2">
                @foreach ($transactions as $transaction)
                    <div class="p-3 border rounded-lg bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($transaction->status) }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">
                                Rp{{ number_format($transaction->total, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Optional: tampilkan item layanan singkat --}}
                        @if ($transaction->items->count())
                            <ul class="mt-2 text-xs text-gray-600 dark:text-gray-400 list-disc list-inside">
                                @foreach ($transaction->items->take(2) as $item)
                                    <li>{{ $item->service->name ?? 'Service tidak ditemukan' }}
                                        (x{{ $item->quantity }})
                                    </li>
                                @endforeach
                                @if ($transaction->items->count() > 2)
                                    <li>...dan {{ $transaction->items->count() - 2 }} item lainnya</li>
                                @endif
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
