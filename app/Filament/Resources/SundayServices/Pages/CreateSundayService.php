<?php

namespace App\Filament\Resources\SundayServices\Pages;

use App\Filament\Resources\SundayServices\SundayServiceResource;
use App\Filament\Traits\ClearsNavigationBadgeCache;
use Filament\Resources\Pages\CreateRecord;

class CreateSundayService extends CreateRecord
{
    use ClearsNavigationBadgeCache;
    
    protected static string $resource = SundayServiceResource::class;
}
