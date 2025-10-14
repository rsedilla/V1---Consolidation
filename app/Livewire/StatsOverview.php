<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\G12Leader;
use App\Models\StartUpYourNewLife;
use App\Models\SundayService;
use App\Models\CellGroup;
use App\Models\LifeclassCandidate;
use App\Models\User;
use App\Traits\ManagesDashboardCache;
use App\Traits\HasDashboardLeaderFiltering;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends StatsOverviewWidget
{
    use ManagesDashboardCache, HasDashboardLeaderFiltering;
    
    protected function getStats(): array
    {
        $user = Auth::user();
        return $this->getCachedDashboardStats($user, 300); // 5 minutes cache
    }
    
    protected function generateStats($user): array
    {
        $stats = [];
        
        // Add summary stats based on user role
        if ($user instanceof User && $user->isAdmin()) {
            $stats = $this->getAdminSummaryStats();
        } elseif ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            $stats = $this->getLeaderSummaryStats($user);
        }
        
        // Add per-leader VIP count cards
        $leaders = $this->getDisplayLeaders($user);
        $stats = array_merge($stats, $this->generateLeaderStats($leaders));
        
        return $stats;
    }
    
    /**
     * Generate summary stats for admin users
     */
    protected function getAdminSummaryStats(): array
    {
        return [
            Stat::make('Total VIPs', Member::vips()->count())
                ->description('All active VIP members')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),
            
            Stat::make('Total Consolidators', Member::consolidators()->count())
                ->description('All active Consolidators')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),
        ];
    }
    
    /**
     * Generate summary stats for leader users
     */
    protected function getLeaderSummaryStats($user): array
    {
        $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
        
        return [
            Stat::make('My Total VIPs', Member::vips()->underLeaders($visibleLeaderIds)->count())
                ->description('VIP members under my leadership')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),
            
            Stat::make('My Lifeclass Candidates', LifeclassCandidate::underLeaders($visibleLeaderIds)->count())
                ->description('Qualified candidates from my members')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning'),
        ];
    }
    
    /**
     * Generate VIP count stats for each leader
     */
    protected function generateLeaderStats($leaders): array
    {
        $stats = [];
        $colors = ['primary', 'warning', 'danger', 'success', 'info'];
        
        foreach ($leaders as $index => $leader) {
            $leaderName = $leader->user->name ?? 'Unknown Leader';
            $descendantIds = $leader->getAllDescendantIds();
            $vipCount = Member::vips()->underLeaders($descendantIds)->count();
            
            $stats[] = Stat::make($leaderName, $vipCount)
                ->description('VIP members')
                ->descriptionIcon('heroicon-o-user')
                ->color($colors[$index % count($colors)]);
        }
        
        return $stats;
    }
    
    /**
     * Clear the cache for the current user's dashboard
     * Useful when data changes and you need to refresh stats immediately
     */
    public static function clearCache($userId = null)
    {
        self::clearDashboardCache($userId);
    }
}
