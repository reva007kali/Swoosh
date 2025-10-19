<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class ListServices extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Service::query())
            ->heading('List Services')
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->label('Nama Service'),
                TextColumn::make('description')
                    ->label('Detail Service'),
                TextColumn::make('description')
                    ->label('Detail Service'),
                TextColumn::make('price')
                    ->label('Harga Service')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('category'),
                BadgeColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(fn(bool $state): string => $state ? 'Aktif' : 'Nonaktif')
                    ->colors([
                        'success' => fn(bool $state): bool => $state === true,
                        'danger' => fn(bool $state): bool => $state === false,
                    ])
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Layanan')
                    ->form([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('description')
                            ->required(),
                        TextInput::make('price')
                            ->required()
                            ->prefix('Rp'),
                        Select::make('category')
                            ->required()
                            ->label('Pilih Kategori')
                            ->options([
                                'Mobil' => 'Mobil',
                                'Motor' => 'Motor'
                            ]),
                        Select::make('is_active')
                            ->label('Status Layanan')
                            ->options([
                                true => 'Aktif',
                                false => 'Nonaktif'
                            ])
                            ->default(true)
                            ->required(),
                    ])
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit')
                    ->form([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('description')
                            ->required(),
                        TextInput::make('price')
                            ->required()
                            ->prefix('Rp'),
                        Select::make('category')
                            ->required()
                            ->label('Pilih Kategori')
                            ->options([
                                'Mobil' => 'Mobil',
                                'Motor' => 'Motor'
                            ]),
                        ToggleButtons::make('is_active')
                            ->label('Status Layanan')
                            ->options([
                                true => 'Aktif',
                                false => 'Nonaktif'
                            ])
                            ->default(true)
                            ->required(),
                            ]),

                            DeleteAction::make('delete')
                            ->label('')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.services.list-services');
    }
}
