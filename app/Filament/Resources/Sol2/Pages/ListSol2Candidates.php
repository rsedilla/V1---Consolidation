<?php

namespace App\Filament\Resources\Sol2\Pages;

use App\Filament\Resources\Sol2\Sol2CandidateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSol2Candidates extends ListRecords
{
    protected static string $resource = Sol2CandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No CreateAction - SOL 2 candidates should only be created via promotion from SOL 1
        ];
    }
}
