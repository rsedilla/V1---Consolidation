<?php

namespace App\Services;

use App\Models\Member;
use App\Models\User;
use App\Models\AuditLog;
use App\Notifications\MemberDeletedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class MemberDeletionService
{
    /**
     * Safely delete a member by reassigning all dependents
     *
     * @param Member $member The member to delete
     * @param int|null $newConsolidatorId ID of the new consolidator for dependents
     * @param int|null $newG12LeaderId ID of the new G12 leader for dependents
     * @return array Result of the deletion process
     */
    public function safeDelete(Member $member, ?int $newConsolidatorId = null, ?int $newG12LeaderId = null): array
    {
        return DB::transaction(function () use ($member, $newConsolidatorId, $newG12LeaderId) {
            $result = [
                'success' => false,
                'message' => '',
                'reassigned_consolidator_dependents' => 0,
                'reassigned_g12_dependents' => 0,
                'deleted_member' => null
            ];

            try {
                // 1. Find all members who have this member as their consolidator
                $consolidatorDependents = Member::where('consolidator_id', $member->id)->get();
                
                // 2. Find all members who have this member as their G12 leader
                $g12Dependents = Member::where('g12_leader_id', $member->g12_leader_id)
                    ->where('id', '!=', $member->id)
                    ->get();

                // 3. Reassign consolidator dependents
                if ($consolidatorDependents->count() > 0) {
                    if ($newConsolidatorId) {
                        Member::where('consolidator_id', $member->id)
                              ->update(['consolidator_id' => $newConsolidatorId]);
                        
                        $result['reassigned_consolidator_dependents'] = $consolidatorDependents->count();
                        Log::info("Reassigned {$consolidatorDependents->count()} members from consolidator {$member->id} to {$newConsolidatorId}");
                    } else {
                        // Set to null if no replacement consolidator provided
                        Member::where('consolidator_id', $member->id)
                              ->update(['consolidator_id' => null]);
                        
                        $result['reassigned_consolidator_dependents'] = $consolidatorDependents->count();
                        Log::info("Set consolidator_id to NULL for {$consolidatorDependents->count()} members");
                    }
                }

                // 4. Reassign G12 leader dependents (if this member was acting as a G12 leader)
                if ($g12Dependents->count() > 0) {
                    if ($newG12LeaderId) {
                        Member::where('g12_leader_id', $member->g12_leader_id)
                              ->where('id', '!=', $member->id)
                              ->update(['g12_leader_id' => $newG12LeaderId]);
                        
                        $result['reassigned_g12_dependents'] = $g12Dependents->count();
                        Log::info("Reassigned {$g12Dependents->count()} members from G12 leader {$member->g12_leader_id} to {$newG12LeaderId}");
                    }
                }

                // 5. Store member info before deletion
                $result['deleted_member'] = [
                    'id' => $member->id,
                    'name' => $member->first_name . ' ' . $member->last_name,
                    'email' => $member->email,
                    'member_type' => $member->memberType?->name,
                ];

                // 6. Log audit entry BEFORE deletion
                AuditLog::log(
                    'delete',
                    'Member',
                    $member->id,
                    $member->toArray(),
                    null,
                    "Member permanently deleted with {$result['reassigned_consolidator_dependents']} consolidator dependents and {$result['reassigned_g12_dependents']} G12 dependents reassigned."
                );

                // 7. Permanently delete the member (no more soft delete)
                $member->delete();

                // 8. Send notification to admin users
                $adminUsers = User::where('role', 'admin')->get();
                $deletedBy = Auth::user()?->name ?? 'System';
                
                foreach ($adminUsers as $admin) {
                    $admin->notify(new MemberDeletedNotification(
                        $result['deleted_member'],
                        $result,
                        $deletedBy
                    ));
                }

                $result['success'] = true;
                $result['message'] = "Member '{$member->first_name} {$member->last_name}' permanently deleted with {$result['reassigned_consolidator_dependents']} consolidator dependents and {$result['reassigned_g12_dependents']} G12 dependents reassigned.";

                Log::info("Successfully permanently deleted member {$member->id} ({$member->first_name} {$member->last_name})");

                return $result;

            } catch (\Exception $e) {
                Log::error("Failed to delete member {$member->id}: " . $e->getMessage());
                
                $result['message'] = "Failed to delete member: " . $e->getMessage();
                return $result;
            }
        });
    }

    /**
     * Get dependents of a member before deletion
     *
     * @param Member $member
     * @return array
     */
    public function getDependents(Member $member): array
    {
        return [
            'consolidator_dependents' => Member::where('consolidator_id', $member->id)->get(),
            'g12_dependents' => Member::where('g12_leader_id', $member->g12_leader_id)
                                     ->where('id', '!=', $member->id)
                                     ->get(),
        ];
    }

    /**
     * Check if a member can be safely deleted
     *
     * @param Member $member
     * @return array
     */
    public function canSafelyDelete(Member $member): array
    {
        $dependents = $this->getDependents($member);
        
        $consolidatorCount = $dependents['consolidator_dependents']->count();
        $g12Count = $dependents['g12_dependents']->count();
        
        return [
            'can_delete' => true, // Always true with reassignment
            'warnings' => [
                'consolidator_dependents' => $consolidatorCount,
                'g12_dependents' => $g12Count,
                'requires_reassignment' => $consolidatorCount > 0 || $g12Count > 0,
            ],
            'message' => $consolidatorCount > 0 || $g12Count > 0 
                ? "This member has dependents that will need reassignment. This deletion is PERMANENT and cannot be undone."
                : "This member can be deleted safely. This deletion is PERMANENT and cannot be undone."
        ];
    }
}