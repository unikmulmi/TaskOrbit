<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter task name')
                    ->autofocus(),
                MarkdownEditor::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->placeholder('Describe the task, requirements, scope, and any important notes...')
                    ->minHeight(200),
                ToggleButtons::make('status')
                    ->inline()
                    ->options([
                        'pending' => 'Pending',
                        'on_hold' => 'On hold',
                        'in_progress' => 'In progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->colors([
                        'pending' => 'gray',
                        'on_hold' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    ])
                    ->icons([
                        'pending' => Heroicon::Clock,
                        'on_hold' => Heroicon::PauseCircle,
                        'in_progress' => Heroicon::ArrowPath,
                        'completed' => Heroicon::CheckBadge,
                        'cancelled' => Heroicon::XCircle,
                    ])
                    ->default('pending')
                    ->required()
                    ->columnSpanFull(),
                ToggleButtons::make('priority')
                    ->inline()
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                    ])
                    ->colors([
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                    ])
                    ->icons([
                        'low' => Heroicon::Flag,
                        'medium' => Heroicon::MinusCircle,
                        'high' => Heroicon::ExclamationTriangle,
                    ])
                    ->default('medium')
                    ->required(),
                DatePicker::make('due_date')
                    ->label('Due Date')
                    ->placeholder('Select a due date')
                    ->native(false)
                    ->minDate(now()),
                Select::make('assigned_user_id')
                    ->relationship('assignedUser', 'name')
                    ->label('Assign Task To')
                    ->default(null)
                    ->searchable()
                    ->preload()
                    ->placeholder('Unassigned'),
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->placeholder('Select a project'),
                Select::make('created_by')
                    ->relationship('creator', 'name')
                    ->searchable()
                    ->preload()
                    ->default(Auth::user()->id)
                    ->required()
                    ->disabled()
                    ->dehydrated(true),
                Select::make('updated_by')
                    ->relationship('updater', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Updated by')
                    ->default(Auth::user()->id)
                    ->required()
                    ->disabled()
                    ->dehydrated(true),
            ]);
    }
}
