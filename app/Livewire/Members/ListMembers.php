<?php

namespace App\Livewire\Members;

use Schema;
use App\Models\Member;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Contracts\View\View;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ListMembers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Member::query())
            ->heading('List Member')
            ->columns([
                ImageColumn::make('user.image_url')
                    ->label('Profile Pict')
                    ->circular()
                    ->height(40)
                    ->width(40),
                TextColumn::make('name')
                    ->label('Nama Member')
                    ->searchable(),
                TextColumn::make('email'),
                TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable(),
                TextColumn::make('balance')->label('Saldo')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('member_point'),
                BadgeColumn::make('vehicles.plate_number')
                    ->color('success')
                    ->label('Kendaraan')

            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('')
                    ->form([
                        Section::make('Informasi User')
                            ->relationship('user') // inilah kunci utamanya!
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama')
                                    ->required(),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required(),

                                TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->required(),

                                FileUpload::make('image')
                                    ->label('Foto Profil')
                                    ->disk('public')
                                    ->directory('image')
                                    ->image()
                                    ->visibility('public')
                                    ->getUploadedFileNameForStorageUsing(
                                        fn(TemporaryUploadedFile $file): string =>
                                        'user-' . now()->timestamp . '.' . $file->getClientOriginalExtension()
                                    ),
                            ])
                            ->columns(2),

                        Section::make('Informasi Member')
                            ->schema([
                                TextInput::make('balance')
                                    ->label('Saldo')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),

                                TextInput::make('member_point')
                                    ->label('Poin')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                            ])
                            ->columns(2),

                        Section::make('Kendaraan')
                            ->schema([
                                Repeater::make('vehicles')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('plate_number')->label('Nomor Plat')->required(),
                                        TextInput::make('type')->label('Tipe')->required(),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel('Tambah Kendaraan'),
                            ]),
                    ]),



                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => route('members.view', $record->qr_code))

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.members.list-members');
    }
}
