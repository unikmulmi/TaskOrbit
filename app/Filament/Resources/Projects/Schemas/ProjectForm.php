<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter project name'),
                MarkdownEditor::make('description')
                    ->columnSpanFull()
                    ->placeholder('Write project details, scope, notes, etc...')
                    ->minHeight(200),
                DateTimePicker::make('start_date')
                    ->label('Start Date')
                    ->native(false)
                    ->displayFormat('M d, Y H:i')
                    ->placeholder('Select start date')
                    ->live(),
                DateTimePicker::make('end_date')
                    ->label('End Date')
                    ->native(false)
                    ->displayFormat('M d, Y H:i')
                    ->placeholder('Select deadline')
                    ->minDate(fn (callable $get) => $get('start_date')),
                FileUpload::make('files')
                    ->multiple()
                    ->disk('public')
                    ->preserveFilenames()
                    ->downloadable()
                    ->openable()
                    ->visibility('public')
                    ->directory('projects')
                    ->columnSpanFull()
                    ->maxSize(5120)
                    ->helperText('Upload project documents, images, or reports')
                    ->reorderable(),
                ToggleButtons::make('status')
                    ->grouped()
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
                    ->label('Updated_by')
                    ->default(Auth::user()->id)
                    ->required()
                    ->disabled()
                    ->dehydrated(true),
            ]);
    }
}
