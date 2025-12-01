<?php

namespace App\Filament\Resources\Books;

use App\Filament\Resources\Books\Pages\CreateBook;
use App\Filament\Resources\Books\Pages\EditBook;
use App\Filament\Resources\Books\Pages\ListBooks;
use App\Filament\Resources\Books\Pages\ViewBook;
use App\Filament\Resources\Books\Tables\BooksTable;
use App\Models\Book;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    public static function getNavigationLabel(): string
    {
        return app()->getLocale() === 'ar' ? 'الكتب' : 'Books';
    }

    public static function getModelLabel(): string
    {
        return app()->getLocale() === 'ar' ? 'كتاب' : 'Book';
    }

    public static function getPluralModelLabel(): string
    {
        return app()->getLocale() === 'ar' ? 'الكتب' : 'Books';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('title_en')
                ->label(app()->getLocale() == 'ar' ? 'العنوان بالانجليزية' : 'Title in English')
                ->required()
                ->maxLength(255),
            TextInput::make('title_ar')
                ->label(app()->getLocale() == 'ar' ? 'العنوان بالعربية' : 'Title in Arabic')
                ->required()
                ->maxLength(255),
            Select::make('author_id')
                ->label(app()->getLocale() == 'ar' ? 'المؤلف' : 'Author')
                ->relationship('author', app()->getLocale() == 'ar' ? 'name_ar' : 'name_en')
                ->required(),
            Textarea::make('description_en')
                ->label(app()->getLocale() == 'ar' ? 'الوصف بالانجليزية' : 'Description in English')
                ->required()
                ->maxLength(1000),
            Textarea::make('description_ar')
                ->label(app()->getLocale() == 'ar' ? 'الوصف بالعربية' : 'Description in Arabic')
                ->required()
                ->maxLength(1000),
            TextInput::make('price')
                ->label(app()->getLocale() == 'ar' ? 'السعر' : 'Price')
                ->required()
                ->numeric()
                ->inputMode('decimal'),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        $language = app()->getLocale();

        return $language == 'ar' ? $schema->schema([
            TextEntry::make('title_ar')
                ->label('العنوان بالعربية'),

            TextEntry::make('author.name_ar')
                ->label('المؤلف بالعربية'),

            TextEntry::make('description_ar')
                ->label('الوصف بالعربية'),

            TextEntry::make('price')
                ->label('السعر'),
        ]) : $schema->schema([
            TextEntry::make('title_en')
                ->label('Title in English'),

            TextEntry::make('author.name_en')
                ->label('Author in English'),

            TextEntry::make('description_en')
                ->label('Description in English'),

            TextEntry::make('price')
                ->label('Price'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return BooksTable::configure($table);
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
            'index' => ListBooks::route('/'),
            'create' => CreateBook::route('/create'),
            'view' => ViewBook::route('/{record}'),
            'edit' => EditBook::route('/{record}/edit'),
        ];
    }
}
