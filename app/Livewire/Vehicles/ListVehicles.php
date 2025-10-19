<?php

namespace App\Livewire\Vehicles;

use App\Models\Vehicle;
use Filament\Actions\DeleteAction;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

class ListVehicles extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Vehicle::query())
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('member.name')->label('Member')->sortable()->searchable(),
                TextColumn::make('plate_number')->label('Nomor Polisi')->sortable()->searchable(),
                TextColumn::make('brand')->label('Brand')->sortable()->searchable(),
                TextColumn::make('model')->label('Model')->sortable(),
                TextColumn::make('color')->label('Warna')->sortable(),
                TextColumn::make('type')->label('Tipe')->sortable(),
                TextColumn::make('year')->label('Tahun')->sortable(),
                TextColumn::make('created_at')->label('Dibuat')->dateTime('d-m-Y H:i')->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.vehicles.list-vehicles');
    }
}
