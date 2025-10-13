<?php

namespace App\Filament\Resources\SolProfiles\Pages;

use App\Filament\Resources\SolProfiles\SolProfileResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Resources\Pages\CreateRecord;

class CreateSolProfile extends CreateRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = SolProfileResource::class;
}
