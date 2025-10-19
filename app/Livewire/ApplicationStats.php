<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApplicationStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalMembers = Member::count();
        $latestMembers = Member::latest()->take(3)->pluck('name')->toArray();
        $latestMembersText = implode(', ', $latestMembers);
        $monthlyRevenue = Transaction::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('grand_total');
        $totalTransactions = Transaction::count();
        return [
            Stat::make('Total Members', $totalMembers),
            Stat::make('Monthly Revenue', 'Rp ' . number_format($monthlyRevenue, 0, ',', '.')),
            Stat::make('Total Transactions', $totalTransactions),
            Stat::make('Latest Members', $latestMembersText),
        ];
    }
}
