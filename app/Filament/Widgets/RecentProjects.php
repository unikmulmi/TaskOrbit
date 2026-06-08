<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentProjects extends TableWidget
{
    protected static ?int $sort = 1;

    protected array|string|int $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Project::query()->latest()->limit(5)->with([
                'creator',
                'updater',
            ]))
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->url(fn(Project $record) => route(
                        'filament.admin.resources.projects.view',
                        $record
                    )),
                TextColumn::make('files')
                    ->label('Attached Files')
                    ->formatStateUsing(function ($state) {

                        if (empty($state)) {
                            return '—';
                        }

                        $files = is_array($state) ? $state : json_decode($state, true);

                        if (!is_array($files)) {
                            $files = [$state];
                        }

                        return collect($files)->map(function ($file) {
                            $url = asset('storage/' . $file);
                            $name = basename($file);

                            return "<a href='{$url}' target='_blank'>📄 {$name}</a>";
                        })->implode('<br>');
                    })
                    ->html()
                    ->toggleable()
                    ->weight('bold'),
                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date('M d, Y')
                    ->placeholder('📅 Not scheduled')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('end_date')
                    ->label('End Date')
                    ->date('M d, Y')
                    ->placeholder('⏳ No deadline set')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
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
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('creator.name')
                    ->label('Creator')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updater.name')
                    ->label('Updated by')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->stackedOnMobile()
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
