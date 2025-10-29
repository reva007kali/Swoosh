<?php

namespace App\Livewire\Transactions;

use Livewire\Component;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class ListTransactions extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {

        return $table
            ->query(fn(): Builder => Transaction::query())
            ->heading('Data Transaksi')
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

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('date')->label('Pilih tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['date'], fn($q, $date) => $q->whereDate('created_at', $date));
                    })
                    ->label('Tanggal Transaksi'),
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('viewDetails')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalHeading('Detail Transaksi')
                    ->modalSubmitAction(false) // Tidak ada tombol "Save"
                    ->modalWidth('xl') // Biar lega
                    ->modalContent(fn($record) => view(
                        'filament.transactions.detail-modal',
                        ['transaction' => $record->load('items.service')]
                    )),

                Action::make('cancelTransaction')
                    ->label('Batalkan Transaksi')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'completed') // hanya bisa cancel yg selesai
                    ->action(function ($record) {
                        $record->load('paymentMethod', 'member');

                        // Cegah double cancel
                        if ($record->status === 'cancelled') {
                            \Filament\Notifications\Notification::make()
                                ->title('Transaksi sudah dibatalkan')
                                ->warning()
                                ->send();
                            return;
                        }

                        $paymentMethod = $record->paymentMethod;
                        $member = $record->member;

                        // 🔹 Refund hanya jika metode pembayarannya "Saldo" atau "Balance"
                        if (str_contains(strtolower($paymentMethod->name), 'saldo member'))
                            {
                            $member->balance += $record->grand_total;
                            $member->save();

                            \Filament\Notifications\Notification::make()
                                ->title('Refund Berhasil')
                                ->body('Saldo sebesar Rp ' . number_format($record->grand_total, 0, ',', '.') . ' telah dikembalikan ke member ' . $member->name . '.')
                                ->success()
                                ->send();
                        }

                        // Ubah status transaksi
                        $record->update(['status' => 'cancelled']);

                        \Filament\Notifications\Notification::make()
                            ->title('Transaksi Dibatalkan')
                            ->body('Transaksi #' . $record->id . ' telah dibatalkan.')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);

    }

    public function render(): View
    {
        return view('livewire.transactions.list-transactions');
    }

}
