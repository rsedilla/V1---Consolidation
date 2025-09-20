<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\StartUpYourNewLife;
use App\Models\SundayService;
use App\Models\CellGroup;
use App\Models\LifeclassCandidate;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
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
            
            Stat::make('Completed Lessons', StartUpYourNewLife::whereNotNull('completion_date')->count())
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
