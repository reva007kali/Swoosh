<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class ListUsers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => User::query())
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                ImageColumn::make('image_url')
                    ->label('Profile Pict')
                    ->circular()
                    ->height(40)
                    ->width(40),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('phone')->sortable()->searchable(),
                TextColumn::make('role.name')->label('Role')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Dibuat')->dateTime('d-m-Y H:i')->sortable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn() => Auth::user()?->role?->name === 'admin')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true), // ignore record saat edit

                        TextInput::make('phone')
                            ->label('Phone')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Select::make('role_id')
                            ->label('Role')
                            ->relationship('role', 'name')
                            ->required(),

                        FileUpload::make('image')
                            ->label('Foto Profil')
                            ->image()
                            ->directory('users')
                            ->disk('public')
                            ->imagePreviewHeight('80') // preview kecil
                            ->nullable(),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn($state) => $state ? bcrypt($state) : null)
                            ->helperText('Kosongkan jika tidak ingin mengubah password')
                            ->required(fn($context) => $context === 'create'), // hanya required saat create
                    ]),

                DeleteAction::make('delete')
                    ->visible(fn() => Auth::user()?->role?->name === 'admin')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }



    public function render(): View
    {
        return view('livewire.users.list-users');
    }
}
