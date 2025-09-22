<?php

namespace App\Filament\Resources\Members\ConsolidatorMemberResource\Pages;

use App\Filament\Resources\Members\ConsolidatorMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditConsolidatorMember extends EditRecord
{
    protected static string $resource = ConsolidatorMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}