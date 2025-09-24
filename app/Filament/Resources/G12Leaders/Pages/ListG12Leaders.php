<?php

namespace App\Filament\Resources\G12Leaders\Pages;

use App\Filament\Resources\G12Leaders\G12LeaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListG12Leaders extends ListRecords
{
    protected static string $resource = G12LeaderResource::class;

    protected static ?string $title = 'G12 Leaders';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New G12 Leader'),
        ];
    }
}