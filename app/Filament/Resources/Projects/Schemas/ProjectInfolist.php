<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Project Name')
                    ->weight('bold')
                    ->color('primary')
                    ->copyable(),
                TextEntry::make('description')
                    ->label('Description')
                    ->placeholder('No description provided. See attached files below.')
                    ->columnSpanFull()
                    ->prose(),
                TextEntry::make('start_date')
                    ->label('Start Date')
                    ->dateTime('M d, Y h:i A') // ->dateTime('M d, Y')
                    ->placeholder('📅 Not scheduled'),
                TextEntry::make('end_date')
                    ->label('End Date')
                    ->dateTime('M d, Y h:i A') // ->dateTime('M d, Y')
                    ->placeholder('⏳ No deadline set'),
                TextEntry::make('files')
                    ->label('Attached Files')
                    ->weight('bold')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return 'No files uploaded';
                        }

                        $files = is_array($state) ? $state : json_decode($state, true);

                        if (!is_array($files)) {
                            $files = [$state];
                        }

                        return collect($files)->map(function ($file) {
                            $url = asset('storage/' . $file);
                            $name = basename($file);

                            return "<a href='{$url}' style='color:#3b82f6;text-decoration:none;' onmouseover=\"this.style.textDecoration='underline';\" onmouseout=\"this.style.textDecoration='none';\" target='_blank'>
                                        📄 {$name}
                                    </a>";
                        })->implode('<br>');
                    })
                    ->html(),
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
                TextEntry::make('creator.name')
                    ->label('Creator')
                    ->placeholder('-'),
                TextEntry::make('updater.name')
                    ->label('Updated_by')
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
