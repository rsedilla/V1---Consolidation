<?php

namespace App\Filament\Resources\SolGraduate\Pages;

use App\Filament\Resources\SolGraduate\SolGraduateResource;
use Filament\Resources\Pages\ListRecords;

class ListSolGraduates extends ListRecords
{
    protected static string $resource = SolGraduateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action - graduates are promoted from SOL 3
        ];
    }
}
