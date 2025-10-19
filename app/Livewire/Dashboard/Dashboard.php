<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Transaction;
use App\Models\Member;

class Dashboard extends Component
{
    public $totalMembers;
    public $monthlyRevenue;
    public $totalTransactions;
    public $latestMembers = [];
    public $latestTransactions = [];
    public $last7Days = [];

    public function mount()
    {
        // Mini stats
        $this->totalMembers = Member::count();
        $this->monthlyRevenue = Transaction::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('grand_total');
        $this->totalTransactions = Transaction::count();

        // Latest members
        $this->latestMembers = Member::latest()->take(3)->get();

        // Latest transactions
        $this->latestTransactions = Transaction::with('member', 'items.service', 'vehicle')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Last 7 days transactions for chart
        $this->last7Days = [
            'dates' => collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('d M'))->toArray(),
            'counts' => collect(range(6, 0))->map(fn($i) => Transaction::whereDate('created_at', now()->subDays($i))->count())->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.index');
    }
}
