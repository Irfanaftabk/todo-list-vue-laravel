<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'due_date',
        'priority',
        'is_completed'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
        'is_completed' => 'boolean'
    ];

    /**
     * Get the categories associated with the task.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'task_category');
    }

    /**
     * Scope a query to filter tasks by priority.
     */
    public function scopeByPriority(Builder $query, string $priority): Builder
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to filter tasks by completion status.
     */
    public function scopeByCompletion(Builder $query, bool $isCompleted): Builder
    {
        return $query->where('is_completed', $isCompleted);
    }

    /**
     * Scope a query to filter tasks by due date range.
     */
    public function scopeByDueDate(Builder $query, string $startDate, ?string $endDate = null): Builder
    {
        if ($endDate) {
            return $query->whereBetween('due_date', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        if ($startDate === 'overdue') {
            return $query->where('due_date', '<', now()->startOfDay());
        }

        if ($startDate === 'today') {
            return $query->whereDate('due_date', '=', now()->toDateString());
        }

        // For week and month
        if ($endDate) {
            return $query->whereBetween('due_date', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        // For specific date
        return $query->whereDate('due_date', '>=', $startDate);
    }

    /**
     * Scope a query to filter tasks by categories.
     */
    public function scopeByCategories(Builder $query, array $categoryIds): Builder
    {
        return $query->whereHas('categories', function ($query) use ($categoryIds) {
            $query->whereIn('categories.id', $categoryIds);
        });
    }

    /**
     * Scope a query to order tasks by due date.
     */
    public function scopeOrderByDueDate(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('due_date', $direction);
    }
}