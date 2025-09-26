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
                Stat::make('My VIPs', Member::whereIn('g12_leader_id', $visibleLeaderIds)->whereHas('memberType', function($query) {
                    $query->where('name', 'VIP');
                })->count())
                    ->description('VIP members under my leadership')
                    ->descriptionIcon('heroicon-o-user-group')
                    ->color('success'),
                
                Stat::make('My Consolidators', Member::whereIn('g12_leader_id', $visibleLeaderIds)->whereHas('memberType', function($query) {
                    $query->where('name', 'Consolidator');
                })->count())
                    ->description('Consolidators under my leadership')
                    ->descriptionIcon('heroicon-o-users')
                    ->color('info'),
                
                Stat::make('Completed Lessons', StartUpYourNewLife::whereHas('member', function($query) use ($visibleLeaderIds) {
                        $query->whereIn('g12_leader_id', $visibleLeaderIds)
                            ->whereHas('memberType', function($subQuery) {
                                $subQuery->where('name', 'VIP');
                            });
                    })
                    ->where(function($query) {
                        $query->whereNotNull('lesson_1_completion_date')
                            ->whereNotNull('lesson_2_completion_date')
                            ->whereNotNull('lesson_3_completion_date')
                            ->whereNotNull('lesson_4_completion_date')
                            ->whereNotNull('lesson_5_completion_date')
                            ->whereNotNull('lesson_6_completion_date')
                            ->whereNotNull('lesson_7_completion_date')
                            ->whereNotNull('lesson_8_completion_date')
                            ->whereNotNull('lesson_9_completion_date')
                            ->whereNotNull('lesson_10_completion_date');
                    })->count())
                    ->description('VIP members who completed ALL SUYNL lessons (1-10)')
                    ->descriptionIcon('heroicon-o-academic-cap')
                    ->color('warning'),
                
                Stat::make('Sunday Services', SundayService::whereHas('member', function($query) use ($visibleLeaderIds) {
                        $query->whereIn('g12_leader_id', $visibleLeaderIds);
                    })->where(function($query) {
                        $query->whereNotNull('sunday_service_1_date')
                            ->whereNotNull('sunday_service_2_date')
                            ->whereNotNull('sunday_service_3_date')
                            ->whereNotNull('sunday_service_4_date');
                    })->count())
                    ->description('Members who completed ALL 4 Sunday services')
                    ->descriptionIcon('heroicon-o-building-library')
                    ->color('primary'),
                
                Stat::make('Cell Groups', CellGroup::whereHas('member', function($query) use ($visibleLeaderIds) {
                        $query->whereIn('g12_leader_id', $visibleLeaderIds);
                    })->where(function($query) {
                        $query->whereNotNull('cell_group_1_date')
                            ->whereNotNull('cell_group_2_date')
                            ->whereNotNull('cell_group_3_date')
                            ->whereNotNull('cell_group_4_date');
                    })->count())
                    ->description('Members who completed ALL 4 cell group sessions')
                    ->descriptionIcon('heroicon-o-user-group')
                    ->color('success'),
                
                Stat::make('My Lifeclass Candidates', LifeclassCandidate::whereHas('member', function($query) use ($visibleLeaderIds) {
                        $query->whereIn('g12_leader_id', $visibleLeaderIds);
                    })->count())
                    ->description('Qualified candidates from my members')
                    ->descriptionIcon('heroicon-o-star')
                    ->color('danger'),
            ];
        }
        
        // Admin users see global stats
        return [
            Stat::make('Total VIPs', Member::whereHas('memberType', function($query) {
                $query->where('name', 'VIP');
            })->count())
                ->description('Active VIP members')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),
            
            Stat::make('Total Consolidators', Member::whereHas('memberType', function($query) {
                $query->where('name', 'Consolidator');
            })->count())
                ->description('Active Consolidators')
                ->descriptionIcon('heroicon-o-users')
                ->color('info'),
            
            Stat::make('Completed Lessons', StartUpYourNewLife::whereHas('member', function($query) {
                $query->whereHas('memberType', function($subQuery) {
                    $subQuery->where('name', 'VIP');
                });
            })->where(function($query) {
                $query->whereNotNull('lesson_1_completion_date')
                    ->whereNotNull('lesson_2_completion_date')
                    ->whereNotNull('lesson_3_completion_date')
                    ->whereNotNull('lesson_4_completion_date')
                    ->whereNotNull('lesson_5_completion_date')
                    ->whereNotNull('lesson_6_completion_date')
                    ->whereNotNull('lesson_7_completion_date')
                    ->whereNotNull('lesson_8_completion_date')
                    ->whereNotNull('lesson_9_completion_date')
                    ->whereNotNull('lesson_10_completion_date');
            })->count())
                ->description('VIP members who completed ALL SUYNL lessons (1-10)')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('warning'),
            
            Stat::make('Sunday Services', SundayService::where(function($query) {
                $query->whereNotNull('sunday_service_1_date')
                    ->whereNotNull('sunday_service_2_date')
                    ->whereNotNull('sunday_service_3_date')
                    ->whereNotNull('sunday_service_4_date');
            })->count())
                ->description('Members who completed ALL 4 Sunday services')
                ->descriptionIcon('heroicon-o-building-library')
                ->color('primary'),
            
            Stat::make('Cell Groups', CellGroup::where(function($query) {
                $query->whereNotNull('cell_group_1_date')
                    ->whereNotNull('cell_group_2_date')
                    ->whereNotNull('cell_group_3_date')
                    ->whereNotNull('cell_group_4_date');
            })->count())
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
