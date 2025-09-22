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
        
        // If user is a leader with G12 assignment, filter all stats by their G12 leader
        if ($user instanceof User && $user->canAccessLeaderData()) {
            $g12LeaderId = $user->getG12LeaderId();
            
            return [
                Stat::make('My VIPs', Member::forG12Leader($g12LeaderId)->whereHas('memberType', function($query) {
                    $query->where('name', 'VIP');
                })->count())
                    ->description('VIP members under my leadership')
                    ->descriptionIcon('heroicon-o-user-group')
                    ->color('success'),
                
                Stat::make('My Consolidators', Member::forG12Leader($g12LeaderId)->whereHas('memberType', function($query) {
                    $query->where('name', 'Consolidator');
                })->count())
                    ->description('Consolidators under my leadership')
                    ->descriptionIcon('heroicon-o-users')
                    ->color('info'),
                
                Stat::make('Completed Lessons', StartUpYourNewLife::forG12Leader($g12LeaderId)
                    ->where(function($query) {
                        $query->whereNotNull('lesson_1_completion_date')
                            ->orWhereNotNull('lesson_2_completion_date')
                            ->orWhereNotNull('lesson_3_completion_date')
                            ->orWhereNotNull('lesson_4_completion_date')
                            ->orWhereNotNull('lesson_5_completion_date')
                            ->orWhereNotNull('lesson_6_completion_date')
                            ->orWhereNotNull('lesson_7_completion_date')
                            ->orWhereNotNull('lesson_8_completion_date')
                            ->orWhereNotNull('lesson_9_completion_date')
                            ->orWhereNotNull('lesson_10_completion_date');
                    })->count())
                    ->description('SUYNL lessons completed by my members')
                    ->descriptionIcon('heroicon-o-academic-cap')
                    ->color('warning'),
                
                Stat::make('Sunday Services', SundayService::forG12Leader($g12LeaderId)->count())
                    ->description('Attendances by my members')
                    ->descriptionIcon('heroicon-o-building-library')
                    ->color('primary'),
                
                Stat::make('Cell Groups', CellGroup::forG12Leader($g12LeaderId)->count())
                    ->description('Attendances by my members')
                    ->descriptionIcon('heroicon-o-user-group')
                    ->color('success'),
                
                Stat::make('My Lifeclass Candidates', LifeclassCandidate::forG12Leader($g12LeaderId)->count())
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
            
            Stat::make('Completed Lessons', StartUpYourNewLife::where(function($query) {
                $query->whereNotNull('lesson_1_completion_date')
                    ->orWhereNotNull('lesson_2_completion_date')
                    ->orWhereNotNull('lesson_3_completion_date')
                    ->orWhereNotNull('lesson_4_completion_date')
                    ->orWhereNotNull('lesson_5_completion_date')
                    ->orWhereNotNull('lesson_6_completion_date')
                    ->orWhereNotNull('lesson_7_completion_date')
                    ->orWhereNotNull('lesson_8_completion_date')
                    ->orWhereNotNull('lesson_9_completion_date')
                    ->orWhereNotNull('lesson_10_completion_date');
            })->count())
                ->description('SUYNL lessons completed')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('warning'),
            
            Stat::make('Sunday Services', SundayService::count())
                ->description('Total attendances')
                ->descriptionIcon('heroicon-o-building-library')
                ->color('primary'),
            
            Stat::make('Cell Groups', CellGroup::count())
                ->description('Total attendances')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),
            
            Stat::make('Lifeclass Candidates', LifeclassCandidate::count())
                ->description('Qualified candidates')
                ->descriptionIcon('heroicon-o-star')
                ->color('danger'),
        ];
    }
}
