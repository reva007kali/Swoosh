<?php

namespace App\Livewire;

use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;

class LatestSales extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Transaction::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                 TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->sortable()
                    ->dateTime('d-m-Y H:i'), // format tanggal & jam
                BadgeColumn::make('status')
                    ->label('Status')
                    ->icons([
                        'heroicon-o-clock' => fn($state) => $state === 'pending',
                        'heroicon-o-check-circle' => fn($state) => $state === 'complete',
                        'heroicon-o-x-circle' => fn($state) => $state === 'cancelled',
                    ])
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->action(
                        Action::make('updateStatus')
                            ->label('Ubah Status')
                            ->visible(fn($record) => $record->status !== 'complete')
                            ->form([
                                Select::make('status')
                                    ->label('Pilih Status Transaksi')
                                    ->options([
                                        'pending' => 'Pending',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required(),
                            ])
                            ->action(function ($record, array $data) {
                                $record->update(['status' => $data['status']]);
                            })
                            ->modalHeading('Ubah Status Transaksi')
                            ->modalButton('Simpan')
                    ),

                TextColumn::make('member.name')
                    ->searchable(),
                // TextColumn::make('vehicle.plate_number'),
                TextColumn::make('cashier.name'),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('discount')
                    ->label('Diskon')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('tax')
                    ->label('Pajak')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('paymentMethod.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
