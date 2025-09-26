<?php

namespace App\Filament\Resources\Members\VipMemberResource\Pages;

use App\Filament\Resources\Members\VipMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVipMember extends ViewRecord
{
    protected static string $resource = VipMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}