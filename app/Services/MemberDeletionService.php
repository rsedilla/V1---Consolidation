<?php

namespace App\Services;

use App\Models\Member;
use App\Models\User;
use App\Models\AuditLog;
use App\Notifications\MemberDeletedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MemberDeletionService
{
    /**
     * Safely delete a member by reassigning all dependents
     * OPTIMIZED VERSION with batch operations and proper relationship handling
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
                // Store member info before deletion (with optimized data loading)
                $result['deleted_member'] = [
                    'id' => $member->id,
                    'name' => $member->first_name . ' ' . $member->last_name,
                    'email' => $member->email,
                    'member_type' => $member->memberType?->name,
                ];

                // OPTIMIZED: Use count() instead of get() for performance, then batch updates
                
                // 1. Handle consolidator dependents (members who have this member as consolidator)
                $consolidatorDependentsCount = Member::where('consolidator_id', $member->id)->count();
                if ($consolidatorDependentsCount > 0) {
                    $updateResult = Member::where('consolidator_id', $member->id)
                        ->update(['consolidator_id' => $newConsolidatorId]);
                    
                    $result['reassigned_consolidator_dependents'] = $consolidatorDependentsCount;
                    
                    $logMessage = $newConsolidatorId 
                        ? "Reassigned {$consolidatorDependentsCount} members from consolidator {$member->id} to {$newConsolidatorId}"
                        : "Set consolidator_id to NULL for {$consolidatorDependentsCount} members";
                    
                    Log::info($logMessage);
                }

                // 2. Handle G12 leader dependents (FIXED LOGIC: members who have the same G12 leader as this member)
                // Only reassign if a new G12 leader is specified
                if ($newG12LeaderId && $member->g12_leader_id) {
                    $g12DependentsCount = Member::where('g12_leader_id', $member->g12_leader_id)
                        ->where('id', '!=', $member->id)
                        ->count();
                    
                    if ($g12DependentsCount > 0) {
                        Member::where('g12_leader_id', $member->g12_leader_id)
                            ->where('id', '!=', $member->id)
                            ->update(['g12_leader_id' => $newG12LeaderId]);
                        
                        $result['reassigned_g12_dependents'] = $g12DependentsCount;
                        Log::info("Reassigned {$g12DependentsCount} members from G12 leader {$member->g12_leader_id} to {$newG12LeaderId}");
                    }
                }

                // 3. Log audit entry BEFORE deletion
                AuditLog::log(
                    'delete',
                    'Member',
                    $member->id,
                    $member->toArray(),
                    null,
                    "Member permanently deleted with {$result['reassigned_consolidator_dependents']} consolidator dependents and {$result['reassigned_g12_dependents']} G12 dependents reassigned."
                );

                // 4. Permanently delete the member
                $member->delete();

                // 5. Send notification to admin users (OPTIMIZED: single query + queue)
                $this->notifyAdmins($result['deleted_member'], $result);

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
     * OPTIMIZED: Send notifications to admins
     */
    private function notifyAdmins(array $memberData, array $result): void
    {
        $deletedBy = Auth::user()?->name ?? 'System';
        
        // Single query to get all admin users
        User::where('role', 'admin')
            ->get()
            ->each(function ($admin) use ($memberData, $result, $deletedBy) {
                $admin->notify(new MemberDeletedNotification($memberData, $result, $deletedBy));
            });
    }

    /**
     * OPTIMIZED: Get dependents of a member before deletion
     * Uses count() instead of get() for better performance when only numbers are needed
     *
     * @param Member $member
     * @param bool $loadRecords Whether to load full records or just counts
     * @return array
     */
    public function getDependents(Member $member, bool $loadRecords = false): array
    {
        if ($loadRecords) {
            // Load full records with minimal data for UI display
            return [
                'consolidator_dependents' => Member::where('consolidator_id', $member->id)
                    ->select('id', 'first_name', 'last_name', 'email')
                    ->get(),
                'g12_dependents' => Member::where('g12_leader_id', $member->g12_leader_id)
                    ->where('id', '!=', $member->id)
                    ->select('id', 'first_name', 'last_name', 'email')
                    ->get(),
            ];
        }

        // Just return counts for performance
        return [
            'consolidator_dependents_count' => Member::where('consolidator_id', $member->id)->count(),
            'g12_dependents_count' => Member::where('g12_leader_id', $member->g12_leader_id)
                ->where('id', '!=', $member->id)
                ->count(),
        ];
    }

    /**
     * OPTIMIZED: Check if a member can be safely deleted
     * Uses count queries instead of full record loading
     *
     * @param Member $member
     * @return array
     */
    public function canSafelyDelete(Member $member): array
    {
        $dependents = $this->getDependents($member);
        
        $consolidatorCount = $dependents['consolidator_dependents_count'];
        $g12Count = $dependents['g12_dependents_count'];
        
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

    /**
     * BATCH DELETE: Delete multiple members efficiently with dependency handling
     *
     * @param array $memberIds Array of member IDs to delete
     * @param int|null $newConsolidatorId ID of the new consolidator for all dependents
     * @param int|null $newG12LeaderId ID of the new G12 leader for all dependents
     * @return array
     */
    public function batchDelete(array $memberIds, ?int $newConsolidatorId = null, ?int $newG12LeaderId = null): array
    {
        return DB::transaction(function () use ($memberIds, $newConsolidatorId, $newG12LeaderId) {
            $result = [
                'success' => false,
                'message' => '',
                'deleted_count' => 0,
                'reassigned_consolidator_dependents' => 0,
                'reassigned_g12_dependents' => 0,
                'errors' => []
            ];

            try {
                // Get members to delete with minimal data
                $members = Member::whereIn('id', $memberIds)
                    ->select('id', 'first_name', 'last_name', 'email', 'g12_leader_id')
                    ->get();

                // Batch reassign consolidator dependents
                $consolidatorCount = Member::whereIn('consolidator_id', $memberIds)
                    ->update(['consolidator_id' => $newConsolidatorId]);
                $result['reassigned_consolidator_dependents'] = $consolidatorCount;

                // Batch reassign G12 dependents if new leader specified
                if ($newG12LeaderId) {
                    $g12LeaderIds = $members->pluck('g12_leader_id')->filter()->unique();
                    if ($g12LeaderIds->isNotEmpty()) {
                        $g12Count = Member::whereIn('g12_leader_id', $g12LeaderIds)
                            ->whereNotIn('id', $memberIds)
                            ->update(['g12_leader_id' => $newG12LeaderId]);
                        $result['reassigned_g12_dependents'] = $g12Count;
                    }
                }

                // Log audit entries and delete
                foreach ($members as $member) {
                    AuditLog::log('delete', 'Member', $member->id, $member->toArray(), null, 
                        "Member batch deleted");
                }

                // Batch delete
                $deletedCount = Member::whereIn('id', $memberIds)->delete();
                $result['deleted_count'] = $deletedCount;

                $result['success'] = true;
                $result['message'] = "Successfully deleted {$deletedCount} members with {$consolidatorCount} consolidator dependents and {$result['reassigned_g12_dependents']} G12 dependents reassigned.";

                Log::info("Batch deleted {$deletedCount} members", ['member_ids' => $memberIds]);

                return $result;

            } catch (\Exception $e) {
                Log::error("Batch delete failed: " . $e->getMessage(), ['member_ids' => $memberIds]);
                $result['message'] = "Batch delete failed: " . $e->getMessage();
                return $result;
            }
        });
    }
}