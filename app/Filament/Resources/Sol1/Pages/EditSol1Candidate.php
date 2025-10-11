<?php

namespace App\Filament\Resources\Sol1\Pages;

use App\Filament\Resources\Sol1\Sol1CandidateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSol1Candidate extends EditRecord
{
    protected static string $resource = Sol1CandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
