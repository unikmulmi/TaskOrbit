<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Task Name')
                    ->weight('bold')
                    ->copyable(),
                TextEntry::make('description')
                    ->label('Task Description')
                    ->placeholder('No description provided.')
                    ->columnSpanFull()
                    ->prose(),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'on_hold' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'on_hold' => 'heroicon-o-pause-circle',
                        'in_progress' => 'heroicon-o-arrow-path',
                        'completed' => 'heroicon-o-check-badge',
                        'cancelled' => 'heroicon-o-x-circle',
                    }),
                TextEntry::make('priority')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'low' => 'heroicon-o-flag',
                        'medium' => 'heroicon-o-minus-circle',
                        'high' => 'heroicon-o-exclamation-triangle',
                    }),
                TextEntry::make('due_date')
                    ->label('Due date')
                    ->dateTime('M d, Y h:i A')
                    ->placeholder('⏳ No deadline set'),
                // TextEntry::make('assignedUser.name')
                //     ->label('Assigned To')
                //     ->placeholder('-')
                //     ->weight('bold'),
                TextEntry::make('assignedUsers.name')
                    ->label('Assigned Users')
                    ->bulleted(),
                TextEntry::make('project.name')
                    ->label('Associated Project')
                    ->color('primary')
                    ->url(
                        fn($record) => $record->project
                            ? ProjectResource::getUrl('view', ['record' => $record->project])
                            : null
                    ),
                TextEntry::make('creator.name')
                    ->label('Task Creator')
                    ->placeholder('-'),
                TextEntry::make('updater.name')
                    ->label('Updated by')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime('M d, Y h:i A')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime('M d, Y h:i A')
                    ->placeholder('-'),
            ]);
    }
}
