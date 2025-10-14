<?php

namespace App\Filament\Resources\Sol2\Pages;

use App\Filament\Resources\Sol2\Sol2CandidateResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Resources\Pages\CreateRecord;

class CreateSol2Candidate extends CreateRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = Sol2CandidateResource::class;
}
