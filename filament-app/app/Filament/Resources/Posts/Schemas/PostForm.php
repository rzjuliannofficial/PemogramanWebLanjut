<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function getSchema(): array
    {
        return [
            // Kolom Kiri (Lebar 2/3)
            Group::make([
                Section::make('Post Details')
                    ->description('Fill in the details of the post')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        // Membagi input dasar menjadi 2 kolom di dalam section
                        Group::make([
                            TextInput::make('title'),
                            TextInput::make('slug'),
                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->preload()
                                ->searchable(),
                            ColorPicker::make('color'),
                        ])->columns(2),
                        
                        // Editor teks mengambil lebar penuh di dalam section
                        MarkdownEditor::make('content')
                            ->columnSpanFull(),
                    ]),
            ])->columnSpan(2),

            // Kolom Kanan (Lebar 1/3)
            Group::make([
                Section::make('Image Upload')
                    ->schema([
                        FileUpload::make('image')
                            ->disk('public')
                            ->directory('posts'),
                    ]),
                    
                Section::make('Meta Information')
                    ->schema([
                        TagsInput::make('tags'),
                        Checkbox::make('published'),
                        DateTimePicker::make('published_at'),
                    ]),
            ])->columnSpan(1),
        ];
    }
}
