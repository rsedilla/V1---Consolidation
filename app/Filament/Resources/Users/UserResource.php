<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Users';

    protected static ?int $navigationSort = 2;

    /**
     * Hide Users navigation for non-admin users
     */
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user instanceof User && $user->isAdmin();
    }

    /**
     * Only allow admins to access user management
     */
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
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
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    /**
     * Configure optimized query with eager loading
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['g12Leader']);
    }

    /**
     * Configure global search for users
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return static::getEloquentQuery()
            ->with(['g12Leader']);
    }

    /**
     * Define searchable attributes for global search
     */
    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'email',
            'role',
            'g12Leader.name',
        ];
    }

    /**
     * Configure global search result title
     */
    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }

    /**
     * Configure global search result details
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];
        
        $details[] = "Email: {$record->email}";
        
        $roleLabel = match ($record->role) {
            'admin' => 'Administrator',
            'leader' => 'Leader',
            'user' => 'User',
            default => 'User',
        };
        $details[] = "Role: {$roleLabel}";
        
        if ($record->g12Leader) {
            $details[] = "G12 Leader: {$record->g12Leader->name}";
        }

        return $details;
    }
}
