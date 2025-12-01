<?php

namespace App\Filament\Resources\Authors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuthorsTable
{
    public static function configure(Table $table): Table
    {
        $language = app()->getLocale();

        return $language == 'ar' ? $table
            ->columns([
                 TextColumn::make('name_ar')
                ->label(('الاسم'))
                ->searchable()
                ->sortable(),
            TextColumn::make('bio_ar')
                ->label('السيرة الذاتية')
                ->limit(50)
                ->wrap(),
            TextColumn::make('email')
                ->label('البريد الالكتروني')
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]) :
         $table
             ->columns([
                   TextColumn::make('name_en')
                 ->label(('name'))
                 ->searchable()
                 ->sortable(),
             TextColumn::make('bio_en')
                 ->label('biography')
                 ->limit(50)
                 ->wrap(),
             TextColumn::make('email')
                 ->label('email')
                 ->searchable(),
             ])
             ->filters([
                 //
             ])
             ->recordActions([
                 ViewAction::make(),
                 EditAction::make(),
                 DeleteAction::make()
             ])
             ->toolbarActions([
                 BulkActionGroup::make([
                     DeleteBulkAction::make(),
                 ]),
             ]);
    }
}
