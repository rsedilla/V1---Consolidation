<?php

namespace App\Filament\Resources\Sol3\Pages;

use App\Filament\Resources\Sol3\Sol3CandidateResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Resources\Pages\CreateRecord;

class CreateSol3Candidate extends CreateRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = Sol3CandidateResource::class;
}
