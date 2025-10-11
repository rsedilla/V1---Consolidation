<?php

namespace App\Filament\Resources\Sol1\Pages;

use App\Filament\Resources\Sol1\Sol1Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSol1 extends EditRecord
{
    protected static string $resource = Sol1Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
