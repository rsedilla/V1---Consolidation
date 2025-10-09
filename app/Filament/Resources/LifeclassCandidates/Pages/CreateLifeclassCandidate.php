<?php

namespace App\Filament\Resources\LifeclassCandidates\Pages;

use App\Filament\Resources\LifeclassCandidates\LifeclassCandidateResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Resources\Pages\CreateRecord;

class CreateLifeclassCandidate extends CreateRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = LifeclassCandidateResource::class;
}
