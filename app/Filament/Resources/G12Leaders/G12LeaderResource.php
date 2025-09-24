<?php

namespace App\Filament\Resources\G12Leaders;

use App\Filament\Resources\G12Leaders\Pages\CreateG12Leader;
use App\Filament\Resources\G12Leaders\Pages\EditG12Leader;
use App\Filament\Resources\G12Leaders\Pages\ListG12Leaders;
use App\Filament\Resources\G12Leaders\Schemas\G12LeaderForm;
use App\Filament\Resources\G12Leaders\Tables\G12LeadersTable;
use App\Models\G12Leader;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class G12LeaderResource extends Resource
{
    protected static ?string $model = G12Leader::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'G12 Leaders';

    protected static ?int $navigationSort = 1;

    /**
     * Hide G12 Leaders navigation for non-admin users
     */
    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user instanceof User && $user->isAdmin();
    }

    /**
     * Only allow admins to access G12 Leaders management
     */
    public static function canViewAny(): bool
    {
        $user = Auth::user();
        return $user instanceof User && $user->isAdmin();
    }

    /**
     * Only allow admins to create G12 Leaders
     */
    public static function canCreate(): bool
    {
        $user = Auth::user();
        return $user instanceof User && $user->isAdmin();
    }

    /**
     * Only allow admins to edit G12 Leaders
     */
    public static function canEdit($record): bool
    {
        $user = Auth::user();
        return $user instanceof User && $user->isAdmin();
    }

    /**
     * Only allow admins to delete G12 Leaders
     */
    public static function canDelete($record): bool
    {
        $user = Auth::user();
        return $user instanceof User && $user->isAdmin();
    }

    /**
     * Override the plural model label
     */
    public static function getPluralModelLabel(): string
    {
        return 'G12 Leaders';
    }

    public static function form(Schema $schema): Schema
    {
        return G12LeaderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return G12LeadersTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['parent', 'user', 'members', 'children']);
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
            'index' => ListG12Leaders::route('/'),
            'create' => CreateG12Leader::route('/create'),
            'edit' => EditG12Leader::route('/{record}/edit'),
        ];
    }
}