<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Filament\Resources\StockResource\RelationManagers;
use App\Models\Stock;
use Carbon\Carbon;
use Filament\Actions\SelectAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Navigation\NavigationItem;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                ->label('Product')
                ->relationship('product', 'name')
                ->required(),
                TextInput::make('quantity')
                ->numeric()
                ->required(),
                TextInput::make('price')
                ->numeric()
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                ->label('Product'),
                TextColumn::make('quantity'),
                TextColumn::make('price'),
                TextColumn::make('created_at')
                ->dateTime()
                ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('d M Y')),
                TextColumn::make('price')->money('INR')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),

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
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
            'bulk-stock-entry' => Pages\BulkStockEntry::route('/bulk-stock-entry'),

        ];
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('Stocks') // 👈 Add back original link
                ->url(self::getUrl('index')) // Links to the main stock list
                ->icon('heroicon-o-rectangle-stack'),


            NavigationItem::make('Bulk Stock Entry') // 👈 Your custom page
                ->url(self::getUrl('bulk-stock-entry'))
                ->icon('heroicon-o-plus-circle')
                ->group('Stock Management'),
        ];
    }




}
