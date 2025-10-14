<?php

namespace App\Filament\Resources\Sol3\Pages;

use App\Filament\Resources\Sol3\Sol3CandidateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSol3Candidates extends ListRecords
{
    protected static string $resource = Sol3CandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
