<div>
    @php
        use App\Models\Transaction;
        use Carbon\Carbon;

        $complete = Transaction::where('status', 'completed')->count();
        $pending = Transaction::where('status', 'pending')->count();
        $cancelled = Transaction::where('status', 'cancelled')->count();
        $todaysRevenue = Transaction::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('grand_total');
        $thisMonthRevenue = Transaction::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('grand_total');
    @endphp


    {{-- Mini Dashboard --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 mb-6">

        <!-- Completed -->
        <div
            class="bg-green-50 dark:bg-green-900 dark:text-green-200 text-green-800 p-5 rounded-2xl shadow hover:shadow-lg transition-shadow duration-200">
            <div class="text-sm font-semibold uppercase tracking-wide">Completed</div>
            <div class="text-3xl font-bold mt-1">{{ $complete }}</div>
        </div>

        <!-- Pending -->
        <div
            class="bg-yellow-50 dark:bg-yellow-900 dark:text-yellow-200 text-yellow-800 p-5 rounded-2xl shadow hover:shadow-lg transition-shadow duration-200">
            <div class="text-sm font-semibold uppercase tracking-wide">Pending</div>
            <div class="text-3xl font-bold mt-1">{{ $pending }}</div>
        </div>

        <!-- Cancelled -->
        <div
            class="bg-red-50 dark:bg-red-900 dark:text-red-200 text-red-800 p-5 rounded-2xl shadow hover:shadow-lg transition-shadow duration-200">
            <div class="text-sm font-semibold uppercase tracking-wide">Cancelled</div>
            <div class="text-3xl font-bold mt-1">{{ $cancelled }}</div>
        </div>

        <!-- Today's Revenue -->
        <div
            class="bg-blue-50 dark:bg-blue-900 dark:text-blue-200 text-blue-800 p-5 rounded-2xl shadow hover:shadow-lg transition-shadow duration-200">
            <div class="text-sm font-semibold uppercase tracking-wide">Today's Revenue</div>
            <div class="text-3xl font-bold mt-1">Rp {{ number_format($todaysRevenue, 0, ',', '.') }}</div>
        </div>

        <!-- This Month Revenue -->
        <div
            class="bg-purple-50 dark:bg-purple-900 dark:text-purple-200 text-purple-800 p-5 rounded-2xl shadow hover:shadow-lg transition-shadow duration-200">
            <div class="text-sm font-semibold uppercase tracking-wide">This Month Revenue</div>
            <div class="text-3xl font-bold mt-1">Rp {{ number_format($thisMonthRevenue, 0, ',', '.') }}</div>
        </div>

    </div>


    {{ $this->table }}
</div>
