<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(app()->getLocale() === 'ar' ? 'الاسم' : 'Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(app()->getLocale() == 'ar' ? 'البريد الالكتروني' : 'email')
                    ->searchable(),
                TextColumn::make('role')
                    ->label(app()->getLocale() == 'ar' ? 'الدور' : 'Role')
                    ->searchable(),

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
