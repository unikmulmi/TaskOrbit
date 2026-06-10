<?php

namespace App\Filament\Resources\Tasks\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssignedUsersRelationManager extends RelationManager
{
    protected static string $relationship = 'assignedUsers';

    protected static ?string $recordTitleAttribute = 'name';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->badge()
                    ->url(
                        fn($record) =>
                        route('filament.admin.resources.users.view', $record)
                    ),
                TextColumn::make('email'),
            ])
            ->recordActions([
            
            ]);
    }
}
