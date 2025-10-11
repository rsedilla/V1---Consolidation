<?php

namespace App\Filament\Resources\Sol1\Pages;

use App\Filament\Resources\Sol1\Sol1Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSol1 extends ListRecords
{
    protected static string $resource = Sol1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
