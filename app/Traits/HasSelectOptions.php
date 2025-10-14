<?php

namespace App\Traits;

use App\Models\G12Leader;
use App\Models\Member;
use Illuminate\Support\Facades\Cache;

trait HasSelectOptions
{
    /**
     * Get available G12 leaders for form selection based on user role
     * Leaders can only select from their hierarchy, admins can select any
     * Results are cached for 30 minutes to improve form load performance
     */
    public function getAvailableG12Leaders(): array
    {
        if ($this->isAdmin()) {
            return $this->getCachedOptions('all_g12_leaders', function () {
                return G12Leader::orderBy('name')->pluck('name', 'id')->toArray();
            });
        }
        
        if ($this->leaderRecord) {
            return $this->getCachedOptions("user_{$this->id}_available_leaders", function () {
                $visibleLeaderIds = $this->getVisibleLeaderIds();
                return G12Leader::whereIn('id', $visibleLeaderIds)
                    ->orderBy('name')
                    ->pluck('name', 'id')
                    ->toArray();
            });
        }

        return [];
    }

    /**
     * Get available consolidators for form selection based on user role
     * Leaders see consolidators in their entire hierarchy (themselves + all descendants)
     * Results are cached for 30 minutes to improve form load performance
     */
    public function getAvailableConsolidators(): array
    {
        if ($this->isAdmin()) {
            return $this->getCachedOptions('all_consolidators', function () {
                return $this->buildConsolidatorOptions(Member::consolidators());
            });
        }
        
        if ($this->leaderRecord) {
            return $this->getCachedOptions("user_{$this->id}_available_consolidators", function () {
                $visibleLeaderIds = $this->getVisibleLeaderIds();
                $query = Member::consolidators()->whereIn('g12_leader_id', $visibleLeaderIds);
                return $this->buildConsolidatorOptions($query, true);
            });
        }

        return [];
    }

    /**
     * Build consolidator options from query with optional self-exclusion
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query Base query
     * @param bool $excludeSelf Whether to exclude the current user
     * @return array Formatted consolidator options
     */
    private function buildConsolidatorOptions($query, bool $excludeSelf = false): array
    {
        $consolidators = $query
            ->select('id', 'first_name', 'last_name', 'email')
            ->orderBy('first_name')
            ->get();

        if ($excludeSelf) {
            $consolidators = $this->filterOutSelf($consolidators);
        }

        return $consolidators
            ->mapWithKeys(fn($member) => [$member->id => $this->formatMemberName($member)])
            ->toArray();
    }

    /**
     * Filter out consolidators that represent the same person as logged-in user
     * 
     * @param \Illuminate\Database\Eloquent\Collection $consolidators
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function filterOutSelf($consolidators)
    {
        $userEmail = strtolower(trim($this->email ?? ''));
        $userName = strtolower(trim($this->name ?? ''));

        return $consolidators->reject(function ($member) use ($userEmail, $userName) {
            // Fast email comparison first
            if (!empty($member->email) && !empty($userEmail)) {
                if (strtolower(trim($member->email)) === $userEmail) {
                    return true;
                }
            }
            
            // Fallback: name comparison
            if (!empty($userName)) {
                $memberFullName = strtolower(trim("{$member->first_name} {$member->last_name}"));
                if ($memberFullName === $userName) {
                    return true;
                }
            }
            
            return false;
        });
    }

    /**
     * Generic cached options retriever
     * 
     * @param string $cacheKey Cache key to use
     * @param callable $callback Function to execute if cache misses
     * @return array Options array
     */
    private function getCachedOptions(string $cacheKey, callable $callback): array
    {
        return Cache::remember($cacheKey, 1800, $callback);
    }

    /**
     * Format member name for display
     */
    private function formatMemberName(Member $member): string
    {
        return $member->first_name . ' ' . $member->last_name;
    }
}
