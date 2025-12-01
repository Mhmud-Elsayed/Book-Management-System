<?php

namespace App\Filament\Resources\Users;

use App\Enum\Role;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function getNavigationLabel(): string
    {
        return app()->getLocale() === 'ar' ? 'المستخدمون' : 'Users';
    }

    public static function getModelLabel(): string
    {
        return app()->getLocale() === 'ar' ? 'مستخدم' : 'User';
    }

    public static function getPluralModelLabel(): string
    {
        return app()->getLocale() === 'ar' ? 'المستخدمون' : 'Users';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label(app()->getLocale() === 'ar' ? 'الاسم' : 'Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(app()->getLocale() == 'ar' ? 'البريد الالكتروني' : 'email')
                    ->email()
                    ->unique("users", "email")
                    ->required()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label(app()->getLocale() == 'ar' ? 'كلمة المرور' : 'Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->maxLength(255),
                Select::make('role')
                    ->label(app()->getLocale() == 'ar' ? 'الدور' : 'Role')
                    ->options(
                       Role::class
                    )
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            TextEntry::make('name')
                ->label(app()->getLocale() === 'ar' ? 'الاسم' : 'Name'),

            TextEntry::make('email')
                ->label(app()->getLocale() === 'ar' ? 'البريد الالكتروني' : 'email'),
            TextEntry::make('role')
                ->label(app()->getLocale() === 'ar' ? 'الدور' : 'Role'),

        ]);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
