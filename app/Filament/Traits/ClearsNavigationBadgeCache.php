<?php

namespace App\Filament\Traits;

use Illuminate\Support\Facades\Auth;

trait ClearsNavigationBadgeCache
{
    /**
     * Clear navigation badge cache after creating a record
     */
    protected function afterCreate(): void
    {
        $this->clearResourceNavigationBadge();
    }
    
    /**
     * Clear navigation badge cache after saving a record
     */
    protected function afterSave(): void
    {
        $this->clearResourceNavigationBadge();
    }
    
    /**
     * Clear the navigation badge for the current resource
     */
    protected function clearResourceNavigationBadge(): void
    {
        $userId = Auth::id();
        $resourceClass = static::getResource();
        
        if (method_exists($resourceClass, 'clearNavigationBadgeCache')) {
            $resourceClass::clearNavigationBadgeCache($userId);
        }
    }
    
    /**
     * Add badge cache clearing to delete actions in getHeaderActions
     * Call this method inside your getHeaderActions() array
     */
    protected function makeDeleteActionWithBadgeClear($action)
    {
        return $action->after(function () {
            $this->clearResourceNavigationBadge();
        });
    }
}
