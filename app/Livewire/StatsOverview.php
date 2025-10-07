<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\StartUpYourNewLife;
use App\Models\SundayService;
use App\Models\CellGroup;
use App\Models\LifeclassCandidate;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        
        // If user is a leader with G12 assignment, filter all stats by their hierarchy
        if ($user instanceof User && $user->isLeader() && $user->leaderRecord) {
            $visibleLeaderIds = $user->leaderRecord->getAllDescendantIds();
            
            return [
                Stat::make('My VIPs', Member::vips()->underLeaders($visibleLeaderIds)->count())
                    ->description('VIP members under my leadership')
                    ->descriptionIcon('heroicon-o-user-group')
                    ->color('success'),
                
                Stat::make('My Consolidators', Member::consolidators()->underLeaders($visibleLeaderIds)->count())
                    ->description('Consolidators under my leadership')
                    ->descriptionIcon('heroicon-o-users')
                    ->color('info'),
                
                Stat::make('Completed Lessons', StartUpYourNewLife::completedForVipsUnderLeaders($visibleLeaderIds)->count())
                    ->description('VIP members who completed ALL SUYNL lessons (1-10)')
                    ->descriptionIcon('heroicon-o-academic-cap')
                    ->color('warning'),
                
                Stat::make('Sunday Services', SundayService::completedUnderLeaders($visibleLeaderIds)->count())
                    ->description('Members who completed ALL 4 Sunday services')
                    ->descriptionIcon('heroicon-o-building-library')
                    ->color('primary'),
                
                Stat::make('Cell Groups', CellGroup::completedUnderLeaders($visibleLeaderIds)->count())
                    ->description('Members who completed ALL 4 cell group sessions')
                    ->descriptionIcon('heroicon-o-user-group')
                    ->color('success'),
                
                Stat::make('My Lifeclass Candidates', LifeclassCandidate::underLeaders($visibleLeaderIds)->count())
                    ->description('Qualified candidates from my members')
                    ->descriptionIcon('heroicon-o-star')
                    ->color('danger'),
            ];
        }
        
        // Admin users see global stats
        return [
            Stat::make('Total VIPs', Member::vips()->count())
                ->description('Active VIP members')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),
            
            Stat::make('Total Consolidators', Member::consolidators()->count())
                ->description('Active Consolidators')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),
            
            Stat::make('Completed Lessons', StartUpYourNewLife::completed()
                ->whereHas('member', function($query) {
                    $query->vips();
                })->count())
                ->description('VIP members who completed ALL SUYNL lessons (1-10)')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('warning'),
            
            Stat::make('Sunday Services', SundayService::completed()->count())
                ->description('Members who completed ALL 4 Sunday services')
                ->descriptionIcon('heroicon-o-building-library')
                ->color('primary'),
            
            Stat::make('Cell Groups', CellGroup::completed()->count())
                ->description('Members who completed ALL 4 cell group sessions')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),
            
            Stat::make('Lifeclass Candidates', LifeclassCandidate::count())
                ->description('Qualified candidates')
                ->descriptionIcon('heroicon-o-star')
                ->color('danger'),
        ];
    }
}
