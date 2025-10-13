<?php

namespace App\Filament\Resources\Sol1\Pages;

use App\Filament\Resources\Sol1\Sol1CandidateResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Resources\Pages\CreateRecord;

class CreateSol1Candidate extends CreateRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = Sol1CandidateResource::class;
}
