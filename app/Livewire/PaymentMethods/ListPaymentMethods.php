<?php

namespace App\Livewire\PaymentMethods;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\PaymentMethod;
use Illuminate\Contracts\View\View;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class ListPaymentMethods extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => PaymentMethod::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('description'),
                TextColumn::make('code')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make('create')
                ->form([
                    TextInput::make('name'),
                    TextInput::make(name: 'description'),
                    TextInput::make('code')
                ])
            ])
            ->recordActions([
                EditAction::make('edit')
                ->form([
                    TextInput::make('name'),
                    TextInput::make('description'),
                    TextInput::make('code'),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.payment-methods.list-payment-methods');
    }
}
