<?php

namespace App\Filament\Resources\Sol1\Pages;

use App\Filament\Resources\Sol1\Sol1CandidateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSol1Candidates extends ListRecords
{
    protected static string $resource = Sol1CandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
