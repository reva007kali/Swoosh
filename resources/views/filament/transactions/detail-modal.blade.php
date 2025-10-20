<div class="space-y-6 p-4 md:p-6 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">

    <!-- Informasi Transaksi -->
    <div class="p-4 md:p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300">
        <h2 class="text-lg font-bold mb-4">Informasi Transaksi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
            <div class="flex justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded">
                <span class="font-medium">ID:</span>
                <span>{{ $transaction->id }}</span>
            </div>
            <div class="flex justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded">
                <span class="font-medium">Tanggal:</span>
                <span>{{ $transaction->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</span>
            </div>
            <div class="flex justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded">
                <span class="font-medium">Member:</span>
                <span>{{ $transaction->member->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded">
                <span class="font-medium">Kendaraan:</span>
                <span>{{ $transaction->vehicle->name ?? '-' }} {{ $transaction->vehicle->plate_number ?? '' }}</span>
            </div>
            <div class="flex justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded">
                <span class="font-medium">Payment:</span>
                <span>{{ $transaction->paymentMethod->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between bg-gray-100 dark:bg-gray-700 p-2 rounded">
                <span class="font-medium">Status:</span>
                <span @class([
                    'px-2 py-1 rounded text-white font-semibold',
                    'bg-green-500' => $transaction->status === 'completed',
                    'bg-yellow-500' => $transaction->status === 'pending',
                    'bg-red-500' => $transaction->status === 'cancelled',
                ])>
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Item Transaksi -->
    <div class="p-4 md:p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300">
        <h2 class="text-lg font-bold mb-4">Item Transaksi</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse border border-gray-200 dark:border-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 dark:text-white">
                    <tr>
                        <th class="p-2 text-left">Nama Item</th>
                        <th class="p-2 text-right">Qty</th>
                        <th class="p-2 text-right">Harga</th>
                        <th class="p-2 text-right">Diskon</th>
                        <th class="p-2 text-right">Pajak</th>
                        <th class="p-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->items as $item)
                        <tr class="border-t hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="p-2">{{ $item->service?->name ?? 'Service tidak ditemukan' }}</td>
                            <td class="p-2 text-right">{{ $item->quantity }}</td>
                            <td class="p-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="p-2 text-right">Rp {{ number_format($transaction->discount,0, ',', ',') }}</td>
                            <td class="p-2 text-right">Rp {{ number_format($transaction->tax ?? 0, 0, ',', '.') }}</td>
                            <td class="p-2 text-right font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Ringkasan Transaksi -->
        <div class="mt-4 flex flex-col md:flex-row justify-end gap-4 text-sm md:text-base font-medium">
            <div class="bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded">Total Item: Rp {{ number_format($transaction->items->sum('subtotal'), 0, ',', '.') }}</div>
            <div class="bg-yellow-200 dark:bg-yellow-600 px-3 py-2 rounded">Total Diskon: Rp {{ number_format($transaction->discount, 0, ',', '.') }}</div>
            <div class="bg-blue-200 dark:bg-blue-600 px-3 py-2 rounded">Total Pajak: Rp {{ number_format($transaction->tax, 0, ',', '.') }}</div>
            <div class="bg-green-200 dark:bg-green-600 px-3 py-2 rounded font-bold">Grand Total: Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
        </div>
    </div>

</div>
