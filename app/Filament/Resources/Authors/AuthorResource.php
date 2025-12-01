<?php

namespace App\Filament\Resources\Authors;

use App\Filament\Resources\Authors\Pages\CreateAuthor;
use App\Filament\Resources\Authors\Pages\EditAuthor;
use App\Filament\Resources\Authors\Pages\ListAuthors;
use App\Filament\Resources\Authors\Pages\ViewAuthor;
use App\Filament\Resources\Authors\Tables\AuthorsTable;
use App\Models\Author;
use BackedEnum;
use Filament\Forms\Components\TextInput;
// use Filament\Schemas\Components\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    public static function getNavigationLabel(): string
    {
        return app()->getLocale() === 'ar' ? 'المؤلفون' : 'Authors';
    }

    public static function getModelLabel(): string
    {
        return app()->getLocale() === 'ar' ? 'مؤلف' : 'Author';
    }

    public static function getPluralModelLabel(): string
    {
        return app()->getLocale() === 'ar' ? 'المؤلفون' : 'Authors';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $form): Schema
    {
        $language = app()->getLocale();

        return $language == 'ar' ? $form->schema([
            TextInput::make('name_ar')
                ->label(' الاسم باللغة العربية ')
                ->placeholder('محمود')
                ->required()
                ->maxLength(255),
            TextInput::make('name_en')
                ->label('الاسم باللغة الانجليزية ')
                ->placeholder('Mahmoud')
                ->required()
                ->maxLength(255),
            TextInput::make('bio_ar')
                ->label('السيرة الذاتية باللغة العربية ')
                ->placeholder('سيرة ذاتية قصيرة عن المؤلف ')
                ->required()
                ->maxLength(1000),
            TextInput::make('bio_en')
                ->label('السيرة الذاتية باللغة الانجليزية ')
                ->placeholder('A short biography about the author ')
                ->required()
                ->maxLength(1000),
            TextInput::make('email')
                ->label('البريد الالكتروني ')
                ->email()
                ->unique('authors', 'email')
                ->required()
                ->maxLength(255),

        ]) : $form->schema([
            TextInput::make('name_ar')
                ->label('Name in Arabic ')
                ->placeholder('محمود')
                ->required()
                ->maxLength(255),
            TextInput::make('name_en')
                ->label('Name in English ')
                ->placeholder('Mahmoud')
                ->required()
                ->maxLength(255),
            TextInput::make('bio_ar')
                ->label('Biography in Arabic ')
                ->placeholder('A short biography about the author ')
                ->required()
                ->maxLength(1000),
            TextInput::make('bio_en')
                ->label('Biography in English ')
                ->placeholder('A short biography about the author ')
                ->required()
                ->maxLength(1000),
            TextInput::make('email')
                ->label('Email ')
                ->email()
                ->unique('authors', 'email')
                ->required()
                ->maxLength(255),

        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        $language = app()->getLocale();

        return $language == 'ar' ? $schema->schema([
            TextEntry::make('name_ar')
                ->label('الاسم'),

            TextEntry::make('bio_ar')
                ->label('السيرة الذاتية')
                ->wrap(),
            TextEntry::make('email')
                ->label('البريد الالكتروني'),
            RepeatableEntry::make('books')
                ->label('الكتب')
                ->schema([
                    TextEntry::make('title_ar')
                        ->label('عنوان الكتاب'),

                ]),

        ]) : $schema->schema([
            TextEntry::make('name_en')
                ->label('Name'),

            TextEntry::make('bio_en')
                ->label('Biography')
                ->wrap(),
            TextEntry::make('email')
                ->label('Email'),
            RepeatableEntry::make('books')
                ->label('Books')
                ->schema([
                    TextEntry::make('title_en')
                        ->label('Book Title'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {

        return AuthorsTable::configure($table);
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
            'index' => ListAuthors::route('/'),
            'create' => CreateAuthor::route('/create'),
            'view' => ViewAuthor::route('/{record}'),
            'edit' => EditAuthor::route('/{record}/edit'),
        ];
    }
}
