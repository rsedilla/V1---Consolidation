<?php

namespace App\Filament\Traits;

use App\Services\MemberDeletionService;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

/**
 * Trait for reusable member deletion actions
 * 
 * Provides consistent delete action configuration with MemberDeletionService
 * integration across all member tables.
 */
trait HasMemberDeletionAction
{
    /**
     * Make a delete action for single member record
     * 
     * @param string $memberType Label for the member type (e.g., 'VIP Member', 'Consolidator Member')
     * @return DeleteAction
     */
    protected static function makeMemberDeleteAction(string $memberType = 'Member'): DeleteAction
    {
        return DeleteAction::make()
            ->requiresConfirmation()
            ->modalHeading("Delete {$memberType}")
            ->modalDescription("Are you sure you want to permanently delete this {$memberType}? This action cannot be undone and will permanently remove all member data from the system.")
            ->modalSubmitActionLabel('Yes, Delete Permanently')
            ->modalIcon('heroicon-o-exclamation-triangle')
            ->color('danger')
            ->before(function ($record) {
                // Use MemberDeletionService for safe deletion with dependency handling
                $deletionService = app(MemberDeletionService::class);
                $result = $deletionService->safeDelete($record);
                
                if (!$result['success']) {
                    throw new \Exception($result['message']);
                }
                
                // Prevent the default delete action since we already handled it
                return false;
            });
    }

    /**
     * Make a bulk delete action for multiple member records
     * 
     * @param string $memberType Label for the member type (e.g., 'VIP Members', 'Consolidator Members')
     * @return DeleteBulkAction
     */
    protected static function makeMemberBulkDeleteAction(string $memberType = 'Members'): DeleteBulkAction
    {
        return DeleteBulkAction::make()
            ->requiresConfirmation()
            ->modalHeading("Delete Selected {$memberType}")
            ->modalDescription("Are you sure you want to permanently delete the selected {$memberType}? This action cannot be undone and will permanently remove all member data from the system.")
            ->modalSubmitActionLabel('Yes, Delete Permanently')
            ->modalIcon('heroicon-o-exclamation-triangle')
            ->color('danger')
            ->action(function ($records) {
                // Use MemberDeletionService for batch safe deletion
                $deletionService = app(MemberDeletionService::class);
                $memberIds = collect($records)->pluck('id')->toArray();
                
                $result = $deletionService->batchDelete($memberIds);
                
                if (!$result['success']) {
                    throw new \Exception($result['message']);
                }
            });
    }
}
