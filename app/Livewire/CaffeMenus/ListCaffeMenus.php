<?php

namespace App\Livewire\CaffeMenus;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component;
use App\Models\CaffeMenu;
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

class ListCaffeMenus extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->heading(
                'Daftar Menu Kafe'
            )
            ->query(fn(): Builder => CaffeMenu::query())
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Gambar')
                    ->rounded(),
                TextColumn::make('name')->label('Nama Menu')->searchable()->sortable(),
                TextColumn::make('description')->label('Deskripsi')->searchable()->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')->label('Kategori')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Menu')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Gambar Menu')
                            ->disk('public')
                            ->directory('caffe-menus')
                            ->image()
                            ->maxSize(3024),
                        TextInput::make('name')->label('Nama Menu')->required(),
                        TextInput::make('description')->label('Deskripsi')->required(),
                        TextInput::make('price')->label('Harga')->numeric()->required(),
                        Select::make('category')->label('Kategori')->required()
                            ->options([
                                'food' => 'Food',
                                'drink' => 'Drink',
                            ]),
                    ]),
            ])
            ->recordActions([
                EditAction::make()
                    ->form([
                        FileUpload::make('image')
                            ->label('Gambar Menu')
                            ->disk('public')
                            ->directory('caffe-menus')
                            ->visibility('public')
                            ->image(),
                        TextInput::make('name')->label('Nama Menu')->required(),
                        TextInput::make('description')->label('Deskripsi')->required(),
                        TextInput::make('price')->label('Harga')->numeric()->required(),
                        Select::make('category')->label('Kategori')->required()
                            ->options([
                                'food' => 'Food',
                                'drink' => 'Drink',
                            ]),
                    ]),
                    DeleteAction::make()
                        ->label('Hapus Menu'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.caffe-menus.list-caffe-menus');
    }
}
