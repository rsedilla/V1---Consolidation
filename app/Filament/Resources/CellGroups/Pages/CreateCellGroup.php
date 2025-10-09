<?php

namespace App\Filament\Resources\CellGroups\Pages;

use App\Filament\Resources\CellGroups\CellGroupResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Resources\Pages\CreateRecord;

class CreateCellGroup extends CreateRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = CellGroupResource::class;
}
