<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Services\MemberDeletionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MemberDeletionController extends Controller
{
    protected MemberDeletionService $deletionService;

    public function __construct(MemberDeletionService $deletionService)
    {
        $this->deletionService = $deletionService;
    }

    /**
     * Check if a member can be safely deleted and show dependents
     */
    public function checkDeletion(Member $member): JsonResponse
    {
        $canDelete = $this->deletionService->canSafelyDelete($member);
        $dependents = $this->deletionService->getDependents($member, true); // Load records for UI

        return response()->json([
            'can_delete' => $canDelete['can_delete'],
            'warnings' => $canDelete['warnings'],
            'message' => $canDelete['message'],
            'dependents' => [
                'consolidator_dependents' => $dependents['consolidator_dependents']->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->first_name . ' ' . $member->last_name,
                        'email' => $member->email,
                    ];
                }),
                'g12_dependents' => $dependents['g12_dependents']->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->first_name . ' ' . $member->last_name,
                        'email' => $member->email,
                    ];
                }),
            ]
        ]);
    }

    /**
     * Safely delete a member with reassignment
     */
    public function safeDelete(Request $request, Member $member): JsonResponse
    {
        $request->validate([
            'new_consolidator_id' => 'nullable|exists:members,id',
            'new_g12_leader_id' => 'nullable|exists:members,id',
        ]);

        $result = $this->deletionService->safeDelete(
            $member,
            $request->new_consolidator_id,
            $request->new_g12_leader_id
        );

        return response()->json($result, $result['success'] ? 200 : 500);
    }

    /**
     * Batch delete members with reassignment
     */
    public function batchDelete(Request $request): JsonResponse
    {
        $request->validate([
            'member_ids' => 'required|array|min:1',
            'member_ids.*' => 'exists:members,id',
            'new_consolidator_id' => 'nullable|exists:members,id',
            'new_g12_leader_id' => 'nullable|exists:members,id',
        ]);

        $result = $this->deletionService->batchDelete(
            $request->member_ids,
            $request->new_consolidator_id,
            $request->new_g12_leader_id
        );

        return response()->json($result, $result['success'] ? 200 : 500);
    }
}

/*
USAGE EXAMPLES:

1. Basic Usage in a Controller:
```php
use App\Services\MemberDeletionService;

$deletionService = new MemberDeletionService();
$member = Member::find(1);

// Check if safe to delete
$check = $deletionService->canSafelyDelete($member);

// Delete with reassignment
$result = $deletionService->safeDelete($member, $newConsolidatorId, $newG12LeaderId);
```

2. Usage in Filament Resource Action:
```php
use App\Services\MemberDeletionService;

// In your MemberResource
Actions\DeleteAction::make()
    ->before(function (Member $record, MemberDeletionService $deletionService) {
        // Check and handle dependents before deletion
        $result = $deletionService->safeDelete($record);
        
        if (!$result['success']) {
            throw new \Exception($result['message']);
        }
    })
```

3. Command Line Usage:
```php
// Create an Artisan command
php artisan make:command SafeDeleteMember

// In the command:
$member = Member::find($memberId);
$deletionService = app(MemberDeletionService::class);
$result = $deletionService->safeDelete($member);
```
*/