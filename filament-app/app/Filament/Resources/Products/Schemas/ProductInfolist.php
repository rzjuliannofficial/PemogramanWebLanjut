<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                    ->tabs([
                        // Tab 1: Product Info
                        Tabs\Tab::make('Product Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('id')
                                    ->label('Product ID'),
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),
                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('success'),
                                TextEntry::make('description')
                                    ->label('Product Description')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),

                        // Tab 2: Pricing & Stock
                        Tabs\Tab::make('Pricing & Stock')
                            ->icon('heroicon-o-currency-dollar')
                            ->badge(fn ($record) => $record->stock)
                            ->badgeColor(fn ($record) => $record->stock > 10 ? 'success' : ($record->stock > 0 ? 'warning' : 'danger'))
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->icon('heroicon-o-cube')
                                    ->color(fn ($state) => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger')),
                            ])
                            ->columns(2),

                        // Tab 3: Media & Status
                        Tabs\Tab::make('Media & Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public')
                                    ->columnSpanFull(),
                                IconEntry::make('is_active')
                                    ->label('Active Status')
                                    ->boolean(),
                                IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->boolean(),
                                TextEntry::make('created_at')
                                    ->label('Created Date')
                                    ->dateTime('d M Y, H:i')
                                    ->color('info'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * Variasi: Implementasi dengan Tabs Vertical
     * Uncomment method ini jika ingin menggunakan Tabs Vertical
     */
    public static function configureVertical(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                    ->vertical()
                    ->tabs([
                        // Tab 1: Product Info
                        Tabs\Tab::make('Product Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('id')
                                    ->label('Product ID'),
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),
                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('success'),
                                TextEntry::make('description')
                                    ->label('Product Description')
                                    ->columnSpanFull(),
                            ])
                            ->columnSpanFull(),

                        // Tab 2: Pricing & Stock
                        Tabs\Tab::make('Pricing & Stock')
                            ->icon('heroicon-o-currency-dollar')
                            ->badge(fn ($record) => $record->stock)
                            ->badgeColor(fn ($record) => $record->stock > 10 ? 'success' : ($record->stock > 0 ? 'warning' : 'danger'))
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->icon('heroicon-o-cube')
                                    ->color(fn ($state) => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger')),
                            ])
                            ->columns(2),

                        // Tab 3: Media & Status
                        Tabs\Tab::make('Media & Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public')
                                    ->columnSpanFull(),
                                IconEntry::make('is_active')
                                    ->label('Active Status')
                                    ->boolean(),
                                IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->boolean(),
                                TextEntry::make('created_at')
                                    ->label('Created Date')
                                    ->dateTime('d M Y, H:i')
                                    ->color('info'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
