<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users' , User::count())
            ->icon('heroicon-o-users'),
            Stat::make('Total Projects' , Project::count())
            ->icon('heroicon-o-folder'),
            Stat::make('Tasks' , Task::count())
            ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('Completed Tasks' , Task::where('status' , 'completed')->count()),
        ];
    }
}
