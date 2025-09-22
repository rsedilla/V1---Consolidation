<?php

namespace App\Filament\Resources\Members\ConsolidatorMemberResource\Pages;

use App\Filament\Resources\Members\ConsolidatorMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConsolidatorMembers extends ListRecords
{
    protected static string $resource = ConsolidatorMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}