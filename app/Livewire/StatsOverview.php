<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\G12Leader;
use App\Models\StartUpYourNewLife;
use App\Models\SundayService;
use App\Models\CellGroup;
use App\Models\LifeclassCandidate;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        
        // Cache key based on user role and ID
        $cacheKey = $user instanceof User && $user->isLeader() && $user->leaderRecord
            ? "dashboard_stats_leader_{$user->id}"
            : "dashboard_stats_admin";
        
        // Cache for 5 minutes (300 seconds)
        return Cache::remember($cacheKey, 300, function () use ($user) {
            return $this->generateStats($user);
        });
    }
    
    protected function generateStats($user): array
    {
        $stats = [];
        
        // Determine which leaders to show based on user role
        // IMPORTANT: Check isAdmin() FIRST before isLeader() because Oriel can be both
        if ($user instanceof User && $user->isAdmin()) {
            // Admin sees all leaders and global stats
            $stats[] = Stat::make('Total VIPs', Member::vips()->count())
                ->description('All active VIP members')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success');
            
            $stats[] = Stat::make('Total Consolidators', Member::consolidators()->count())
                ->description('All active Consolidators')
                ->descriptionIcon('heroicon-o-users')
                ->color('info');
            
            // Get only the direct 12 leaders (top level - those without parents or direct children of root)
            // Find the root leader (Oriel Ballano or whoever is at the top)
            $rootLeader = G12Leader::whereNull('parent_id')->first();
            
            if ($rootLeader) {
                // Get direct children of the root leader only
                $leaders = G12Leader::with('user')
                    ->where('parent_id', $rootLeader->id)
                    ->whereHas('user')
                    ->get()
                    ->sortBy(function($leader) {
                        return $leader->user->name ?? '';
                    });
            } else {
                // Fallback: if no root, show top-level leaders (those without parents)
                $leaders = G12Leader::with('user')
                    ->whereNull('parent_id')
                    ->whereHas('user')
                    ->get()
                    ->sortBy(function($leader) {
                        return $leader->user->name ?? '';
                    });
            }
        } elseif ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            // Leader sees their own hierarchy only
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            
            // Show total VIPs under this leader
            $stats[] = Stat::make('My Total VIPs', Member::vips()->underLeaders($visibleLeaderIds)->count())
                ->description('VIP members under my leadership')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success');
            
            // Show Lifeclass Candidates under this leader (replaces Consolidators card)
            $stats[] = Stat::make('My Lifeclass Candidates', LifeclassCandidate::underLeaders($visibleLeaderIds)->count())
                ->description('Qualified candidates from my members')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning');
            
            // Get only the DIRECT children (direct 12) of this leader
            $leaders = G12Leader::with('user')
                ->where('parent_id', $user->leaderRecord->id) // Only direct children
                ->whereHas('user')
                ->get()
                ->sortBy(function($leader) {
                    return $leader->user->name ?? '';
                });
        } else {
            // No leader record or not authenticated properly
            $leaders = collect();
        }
        
        // Per-leader VIP count cards (sorted alphabetically)
        $colors = ['primary', 'warning', 'danger', 'success', 'info'];
        $colorIndex = 0;
        
        foreach ($leaders as $leader) {
            $leaderName = $leader->user->name ?? 'Unknown Leader';
            $descendantIds = $leader->getAllDescendantIds();
            $vipCount = Member::vips()->underLeaders($descendantIds)->count();
            
            $stats[] = Stat::make($leaderName, $vipCount)
                ->description('VIP members')
                ->descriptionIcon('heroicon-o-user')
                ->color($colors[$colorIndex % count($colors)]);
            
            $colorIndex++;
        }
        
        return $stats;
    }
    
    /**
     * Clear the cache for the current user's dashboard
     * Useful when data changes and you need to refresh stats immediately
     */
    public static function clearCache($userId = null)
    {
        if ($userId) {
            $user = User::find($userId);
            if ($user && $user->isLeader() && $user->leaderRecord) {
                Cache::forget("dashboard_stats_leader_{$userId}");
            } else {
                Cache::forget("dashboard_stats_admin");
            }
        } else {
            // Clear all dashboard caches
            Cache::forget("dashboard_stats_admin");
            // Note: Individual leader caches will expire naturally after 5 minutes
        }
    }
}
