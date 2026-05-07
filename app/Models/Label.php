<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Label extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'color'];

    /**
     * The tasks that belong to the Label
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_label');
    }

    public function canBeDeleted(): bool
    {
        return $this->tasks()->count() === 0;
    }
}
