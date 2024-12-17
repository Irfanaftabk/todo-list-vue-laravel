<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the tasks associated with the category.
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_category');
    }

    /**
     * Get active tasks in this category.
     */
    public function activeTasks(): BelongsToMany
    {
        return $this->tasks()->where('is_completed', false);
    }

    /**
     * Get completed tasks in this category.
     */
    public function completedTasks(): BelongsToMany
    {
        return $this->tasks()->where('is_completed', true);
    }
}
