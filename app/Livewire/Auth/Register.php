<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Member;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';
    public string $phone = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^[0-9]+$/', 'unique:users,phone'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Ambil role member dari tabel roles
        $memberRoleId = \App\Models\Role::where('name', 'member')->value('id');

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
            'role_id' => $memberRoleId, // default member
        ]);

        // (Opsional) Buat juga profil member
        Member::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'balance' => 0,
            'member_point' => 0,
        ]);

        event(new Registered($user));

        Auth::login($user);

        Session::regenerate();

        // Cari profil member yang barusan dibuat
        $member = Member::where('user_id', $user->id)->first();

        // Kalau user adalah member, arahkan ke profil mereka
        if ($user->role?->name === 'member' && $member) {
            $this->redirect(
                route('members.view', ['qr_code' => $member->qr_code]),
                navigate: true
            );
            return;
        }

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

}
