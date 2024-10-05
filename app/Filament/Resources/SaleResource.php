<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                ->relationship('products', 'nombre')
                ->preload()
                ->required()
                ->searchable()
                ->reactive()  
                ->afterStateUpdated(function ($state, callable $set) {
                    // Obtener el precio del producto seleccionado y establecerlo en el campo 'price'
                    $product = \App\Models\Product::find($state);
                    if ($product) {
                        $set('preciounitario', $product->PrecioVenta);
                    }
                }),
                Forms\Components\Select::make('customer_id')
                ->relationship('customers','nombre')
                ->required()
                ->searchable()
                ->preload(),
                Forms\Components\TextInput::make('cantidad')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('preciounitario')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('preciodeventa')
                    ->numeric()
                    ->disabled()
                    ->visibleOn(['edit', 'view'])
                    ->default(null),
                Forms\Components\TextInput::make('soporteventa')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('products.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customers.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cantidad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('products.PrecioVenta')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('preciodeventa')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('soporteventa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
