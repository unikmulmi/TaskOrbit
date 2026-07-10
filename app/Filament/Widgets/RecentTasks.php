<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentTasks extends TableWidget
{
    use HasWidgetShield;

    protected array|string|int $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '15s';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Task::query()->latest()->limit(5)->with([
                'creator',
                'updater',
                'assignedUsers',
                'project',
            ]))
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight('bold')
                    ->url(fn(Task $record) => route(
                        'filament.admin.resources.tasks.view',
                        $record
                    )),
                TextColumn::make('description')
                    ->limit(50) // words(10) also works.
                    ->toggleable(isToggledHiddenByDefault: true),
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
                TextColumn::make('priority')
                    ->badge()
                    ->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'low' => 'heroicon-o-flag',
                        'medium' => 'heroicon-o-minus-circle',
                        'high' => 'heroicon-o-exclamation-triangle',
                    })
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date('M d, Y')
                    ->placeholder('⏳ No deadline set')
                    ->sortable(),
                // TextColumn::make('assignedUser.name')
                //     ->label('Assigned To')
                //     ->placeholder('Unassigned')
                //     ->searchable()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('assignedUsers.name')
                    ->label('Assigned Users')
                    ->badge()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('project.name')
                    ->searchable()
                    ->sortable()
                    ->url(
                        fn($record) => $record->project ?
                            route('filament.admin.resources.projects.view', $record->project)
                            : null
                    ),
                TextColumn::make('creator.name')
                    ->label('Task Creator')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updater.name')
                    ->label('Task Updater')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-')
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
