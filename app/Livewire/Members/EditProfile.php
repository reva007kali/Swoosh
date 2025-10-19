<?php

namespace App\Livewire\Members;

use Filament\Forms;
use App\Models\Member;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Components\Form;
use Illuminate\Support\Facades\Storage;
use Filament\Schemas\Components\Section;

class EditProfile extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public ?Member $member = null;

    public function mount($memberId = null): void
    {
        // Tentukan member yang akan ditampilkan
        $this->member = $memberId
            ? Member::with(['user', 'vehicles'])->findOrFail($memberId)
            : Auth::user()->member()->with(['user', 'vehicles'])->first();

        // Isi form dengan data awal
        $this->form->fill([
            'name' => $this->member->user->name ?? '',
            'email' => $this->member->user->email ?? '',
            'phone' => $this->member->user->phone ?? '',
            'image' => $this->member->user->image ?? null,
            'balance' => $this->member->balance ?? 0,
            'member_point' => $this->member->member_point ?? 0,
            'vehicles' => $this->member->vehicles->map(fn($v) => [
                'name' => $v->name,
                'plate_number' => $v->plate_number,
                'type' => $v->type,
                'color' => $v->color,
            ])->toArray(),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Member')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Foto Profil')
                            ->image()
                            ->directory('profile-images')
                            ->maxSize(2048),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor HP')
                            ->required(),
                    ])->columns(2),

                Section::make('Informasi Tambahan')
                    ->schema([
                        Forms\Components\TextInput::make('balance')
                            ->label('Saldo')
                            ->disabled(),

                        Forms\Components\TextInput::make('member_point')
                            ->label('Poin Member')
                            ->disabled(),
                    ])->columns(2),

                Section::make('Kendaraan')
                    ->schema([
                        Forms\Components\Repeater::make('vehicles')
                            ->label('Daftar Kendaraan')
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Nama Kendaraan'),
                                Forms\Components\TextInput::make('plate_number')->label('Plat Nomor'),
                                Forms\Components\Select::make('type')
                                    ->label('Tipe')
                                    ->options([
                                        'motor' => 'Motor',
                                        'mobil' => 'Mobil',
                                        'lainnya' => 'Lainnya',
                                    ]),
                                Forms\Components\TextInput::make('color')->label('Warna'),
                            ])->columns(2),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Update user data
        $user = $this->member->user;
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'image' => $data['image'] ?? $user->image,
        ]);

        // Update vehicle data
        $this->member->vehicles()->delete();
        foreach ($data['vehicles'] ?? [] as $vehicleData) {
            $this->member->vehicles()->create($vehicleData);
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Profil berhasil diperbarui!',
        ]);
    }

    public function render()
    {
        return view('livewire.members.edit-profile');
    }
}
