<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'priority',
        'due_date',
        'assigned_user_id',
        'project_id',
        'created_by',
        'updated_by',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class , 'updated_by');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
