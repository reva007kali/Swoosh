<div class="space-y-6">

    <flux:navlist.item icon="qr-code" :href="route('scan.member')" :current="request()->routeIs('scan.member')"
        wire:navigate class="!bg-blue-500 !text-white hover:!bg-blue-600 !mb-10 !w-fit !rounded-full">
        {{ __('Scan Member Card') }}
    </flux:navlist.item>
    <!-- Mini Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <div
            class="p-6 rounded-2xl shadow-lg bg-gradient-to-r from-blue-500 to-blue-400 text-white flex items-center gap-4 transition-transform transform hover:scale-105">
            <div class="text-3xl font-bold">{{ $totalMembers }}</div>
            <div>
                <div class="text-sm font-medium">Total Members</div>
                <div class="text-xs opacity-80">All registered users</div>
            </div>
            <div class="ml-auto text-3xl">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div
            class="p-6 rounded-2xl shadow-lg bg-gradient-to-r from-green-500 to-green-400 text-white flex items-center gap-4 transition-transform transform hover:scale-105">
            <div class="text-3xl font-bold">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
            <div>
                <div class="text-sm font-medium">Monthly Revenue</div>
                <div class="text-xs opacity-80">Completed transactions</div>
            </div>
            <div class="ml-auto text-3xl">
                <i class="fas fa-wallet"></i>
            </div>
        </div>

        <div
            class="p-6 rounded-2xl shadow-lg bg-gradient-to-r from-yellow-500 to-yellow-400 text-white flex items-center gap-4 transition-transform transform hover:scale-105">
            <div class="text-3xl font-bold">{{ $totalTransactions }}</div>
            <div>
                <div class="text-sm font-medium">Total Transactions</div>
                <div class="text-xs opacity-80">All-time transactions</div>
            </div>
            <div class="ml-auto text-3xl">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>

    <!-- Last 7 Days Transactions Chart -->
    {{-- <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300">
        <h3 class="text-xl font-bold mb-4">Transactions Last 7 Days</h3>
        <canvas id="transactionsChart" class="w-full h-64"></canvas>
    </div> --}}

    <!-- Latest Members -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300">
        <h3 class="text-xl font-bold mb-4">3 Latest Members</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 dark:bg-gray-900 dark:text-gray-100 sticky top-0">
                    <tr>
                        <th class="p-2 text-left">Name</th>
                        <th class="p-2 text-left">Email</th>
                        <th class="p-2 text-left">Phone</th>
                        <th class="p-2 text-left">Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestMembers as $member)
                        <tr
                            class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="p-2">{{ $member->name }}</td>
                            <td class="p-2">{{ $member->email }}</td>
                            <td class="p-2">{{ $member->phone }}</td>
                            <td class="p-2">{{ $member->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-2 text-center text-gray-500">No members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Latest Transactions -->
    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md transition-colors duration-300">
        <h3 class="text-xl font-bold mb-4">5 Latest Transactions</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 dark:bg-gray-900 dark:text-gray-100 sticky top-0">
                    <tr>
                        <th class="p-2 text-left">Date</th>
                        <th class="p-2 text-left">Member</th>
                        <th class="p-2 text-left">Vehicle</th>
                        <th class="p-2 text-left">Service</th>
                        <th class="p-2 text-right">Qty</th>
                        <th class="p-2 text-right">Subtotal</th>
                        <th class="p-2 text-right">Grand Total</th>
                        <th class="p-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestTransactions as $trans)
                        @foreach ($trans->items as $item)
                            <tr
                                class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="p-2">{{ $trans->created_at->format('d-m-Y H:i') }}</td>
                                <td class="p-2">{{ $trans->member->name ?? '-' }}</td>
                                <td class="p-2">{{ $trans->vehicle->plate_number ?? '-' }}</td>
                                <td class="p-2">{{ $item->service->name ?? '-' }}</td>
                                <td class="p-2 text-right">{{ $item->quantity }}</td>
                                <td class="p-2 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td class="p-2 text-right">Rp {{ number_format($trans->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="p-2">
                                    <span @class([
                                        'px-2 py-1 rounded text-white text-sm',
                                        'bg-green-500' => $trans->status === 'completed',
                                        'bg-yellow-500' => $trans->status === 'pending',
                                        'bg-red-500' => $trans->status === 'cancelled',
                                    ])>
                                        {{ ucfirst($trans->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="8" class="p-2 text-center text-gray-500">No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
