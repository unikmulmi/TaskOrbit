<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemOverview extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->icon('heroicon-o-users')
                ->description('Registered system users'),
            Stat::make('Total Projects', Project::count())
                ->icon('heroicon-o-folder')
                ->description('Projects being tracked'),
            Stat::make('Tasks', Task::count())
                ->icon('heroicon-o-clipboard-document-list')
                ->description('Tasks across all projects'),
            Stat::make('Completed Tasks', Task::where('status', 'completed')->count())
                ->icon('heroicon-o-check-circle')
                ->description('Successfully completed'),
        ];
    }
}
