<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class PostsTable
{
    public static function configure(Table $table): Table
    {
    return $table
        ->defaultSort('created_at', 'desc')
        ->columns([
            TextColumn::make('id')
                ->label('ID')
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('title')
                ->sortable()
                ->searchable()
                ->toggleable(),
            TextColumn::make('slug')
                ->sortable()
                ->searchable()
                ->toggleable(),
            TextColumn::make('category.name')
                ->sortable()
                ->searchable()
                ->toggleable(),
            IconColumn::make('published')
                ->boolean()
                ->label('Published')
                ->toggleable(),
            TextColumn::make('tags')
                ->label('Tags')
                ->toggleable(isToggledHiddenByDefault: true),
            ColorColumn::make('color')
                ->toggleable(),
            ImageColumn::make('image')
                ->disk('public')
                ->toggleable(),
            TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime()
                ->sortable()
                ->toggleable(),
        ])
        ->filters([
            Filter::make('created_at')
                ->label('Creation Date')
                ->schema([
                    DatePicker::make('created_at')
                        ->label('Select Date'),
                ])
                ->query(function ($query, $data) {
                    return $query->when(
                        $data['created_at'],
                        fn ($query, $date) => $query->whereDate('created_at', $date)
                    );
                }),
            SelectFilter::make('category_id')
                ->label('Select Category')
                ->relationship('category', 'name')
                ->preload(),
        ])
        ->recordActions([
            EditAction::make(),
        ])
        ->toolbarActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ]);
    }   
}
