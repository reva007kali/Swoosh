<?php

use App\Livewire\TransactionItems\ListTransactionItems;
use Laravel\Fortify\Features;
use App\Livewire\Roles\ListRoles;
use App\Livewire\Users\ListUsers;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Members\ViewMember;
use App\Livewire\Settings\TwoFactor;
use App\Http\Controllers\MemberCardController;
use App\Livewire\Members\ListMembers;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Livewire\Services\ListServices;
use App\Livewire\Vehicles\ListVehicles;
use App\Livewire\Transactions\ListTransactions;
use App\Livewire\PaymentMethods\ListPaymentMethods;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/member-card/{member}/download', [MemberCardController::class, 'download'])->name('member.card.download');


    Route::get('/manage-users', ListUsers::class)->name('users.index');
    Route::get('/manage-services', ListServices::class)->name('services.index');

    Route::get('/manage-members', ListMembers::class)->name('members.index');
    Route::get('/members/{qr_code}', ViewMember::class)
        ->name('members.view');


    Route::get('/manage-roles', ListRoles::class)->name('roles.index');
    Route::get('/manage-payment-methods', ListPaymentMethods::class)->name('payment.methods.index');
    Route::get('/manage-transactions', ListTransactions::class)->name('transactions.index');
    Route::get('/manage-transaction-items', ListTransactionItems::class)->name('transaction.items.index');
    Route::get('/manage-vehicles', ListVehicles::class)->name('vehicles.index');
});

require __DIR__ . '/auth.php';
