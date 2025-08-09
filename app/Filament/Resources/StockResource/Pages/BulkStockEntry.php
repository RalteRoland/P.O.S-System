<?php

namespace App\Filament\Resources\StockResource\Pages;


use App\Filament\Resources\StockResource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Select;
use App\Models\Product;


class BulkStockEntry extends Page implements HasForms
{
    protected static string $resource = StockResource::class;

    protected static string $view = 'filament.resources.stock-resource.pages.bulk-stock-entry';

    use InteractsWithForms;

    protected function getFormSchema(): array
    {
        return [
            Repeater::make('stocks') // the name 'stocks' will be our form data key
                ->label('Bulk Stock Entries') // the heading for the repeater box
                ->schema([
                    Select::make('product_id')
                        ->label('Product')
                        ->options(Product::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                ]) // no sub-fields yet — we'll add them later
                ->createItemButtonLabel('Add Stock Entry'), // text for the add button
        ];
    }

    
}
