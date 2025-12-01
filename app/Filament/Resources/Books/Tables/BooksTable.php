<?php

namespace App\Filament\Resources\Books\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        $language = app()->getLocale();

        return $language == 'ar' ?
         $table
             ->columns([
                 TextColumn::make('title_ar')
                     ->label('العنوان ')
                     ->searchable()
                     ->sortable(),
                 TextColumn::make('description_ar')
                     ->label('وصف الكتاب')
                     ->searchable(),
                 TextColumn::make('price')
                     ->label('السعر')
                     ->searchable()
                     ->sortable(),
                 TextColumn::make('author.name_ar')
                     ->label('اسم المؤلف')
                     ->searchable()
                     ->sortable(),

             ])
             ->filters([
                 //
             ])
             ->recordActions([
                 ViewAction::make(),
                 EditAction::make(),
             ])
             ->toolbarActions([
                 BulkActionGroup::make([
                     DeleteBulkAction::make(),
                 ]),
             ]) :
            $table
                ->columns([
                    TextColumn::make('title_en')
                        ->label('Title ')
                        ->searchable()
                        ->sortable(),
                    TextColumn::make('description_en')
                        ->label('Book Description')
                        ->limit(50)
                        ->searchable(),
                    TextColumn::make('price')
                        ->label('Price')
                        ->searchable()
                        ->sortable(),
                    TextColumn::make('author.name_en')
                        ->label('Author Name')
                        ->searchable()
                        ->sortable(),

                ])
                ->filters([
                    //
                ])
                ->recordActions([
                    ViewAction::make(),
                    EditAction::make(),
                ])
                ->toolbarActions([
                    BulkActionGroup::make([
                        DeleteBulkAction::make(),
                    ]),
                ]);

    }
}
