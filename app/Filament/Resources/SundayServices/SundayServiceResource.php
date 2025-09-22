<?php

namespace App\Filament\Resources\SundayServices;

use App\Filament\Resources\SundayServices\Pages\CreateSundayService;
use App\Filament\Resources\SundayServices\Pages\EditSundayService;
use App\Filament\Resources\SundayServices\Pages\ListSundayServices;
use App\Filament\Resources\SundayServices\Schemas\SundayServiceForm;
use App\Filament\Resources\SundayServices\Tables\SundayServicesTable;
use App\Models\SundayService;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SundayServiceResource extends Resource
{
    protected static ?string $model = SundayService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Sunday Services';

    protected static ?int $navigationSort = 4;

    /**
     * Filter records based on user role and G12 leader assignment
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        
        // Eager load the member and consolidator relationships to optimize database queries
        $query = parent::getEloquentQuery()->with(['member', 'member.consolidator']);
        
        if ($user instanceof User && $user->canAccessLeaderData()) {
            // Leaders see only records for their assigned members
            return $query->forG12Leader($user->getG12LeaderId());
        }
        
        // Admins see everything, other users see nothing
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return SundayServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SundayServicesTable::configure($table);
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
            'index' => ListSundayServices::route('/'),
            'create' => CreateSundayService::route('/create'),
            'edit' => EditSundayService::route('/{record}/edit'),
        ];
    }
}
