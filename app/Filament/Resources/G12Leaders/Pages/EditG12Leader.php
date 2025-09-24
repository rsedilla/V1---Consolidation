<?php

namespace App\Filament\Resources\G12Leaders\Pages;

use App\Filament\Resources\G12Leaders\G12LeaderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditG12Leader extends EditRecord
{
    protected static string $resource = G12LeaderResource::class;

    protected static ?string $title = 'Edit G12 Leader';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Delete G12 Leader')
                ->modalDescription('Are you sure you want to delete this G12 leader? This will remove their assignment from members and users.')
                ->modalSubmitActionLabel('Yes, Delete')
                ->color('danger'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}