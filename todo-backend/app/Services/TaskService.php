<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TaskService
{
    /**
     * Create a new task with categories
     */
    public function createTask(array $data): Task
    {
        return DB::transaction(function () use ($data) {
            $task = Task::create([
                'description' => $data['description'],
                'due_date' => $data['due_date'] ?? null,
                'priority' => $data['priority'],
                'is_completed' => $data['is_completed'] ?? false,
            ]);

            if (!empty($data['category_ids'])) {
                $task->categories()->attach($data['category_ids']);
            }

            return $task->load('categories');
        });
    }

    /**
     * Update an existing task and its categories
     */
    public function updateTask(Task $task, array $data): Task
    {
        return DB::transaction(function () use ($task, $data) {
            $task->update([
                'description' => $data['description'] ?? $task->description,
                'due_date' => $data['due_date'] ?? $task->due_date,
                'priority' => $data['priority'] ?? $task->priority,
                'is_completed' => $data['is_completed'] ?? $task->is_completed,
            ]);

            if (isset($data['category_ids'])) {
                $task->categories()->sync($data['category_ids']);
            }

            return $task->load('categories');
        });
    }

    /**
     * Filter tasks based on various criteria
     */
    public function filterTasks(array $filters): Collection
    {
        $query = Task::query()->with('categories');

        // Apply priority filter
        if (!empty($filters['priority'])) {
            $query->byPriority($filters['priority']);
        }

        // Apply completion status filter
        if (isset($filters['is_completed'])) {
            $isCompleted = filter_var($filters['is_completed'], FILTER_VALIDATE_BOOLEAN);
            $query->byCompletion($isCompleted);
        }

        // Apply due date filter
        if (!empty($filters['due_date'])) {
            $dates = $this->parseDueDateFilter($filters['due_date']);
            $query->byDueDate($dates['start'], $dates['end'] ?? null);
        }

        // Apply category filter
        if (!empty($filters['category_ids'])) {
            $query->byCategories($filters['category_ids']);
        }

        // Apply default ordering
        return $query->orderBy('due_date', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    /**
     * Parse the due date filter string into start and end dates
     */
    protected function parseDueDateFilter(string $dueDateFilter): array
    {
        // Handle various date filter formats
        switch ($dueDateFilter) {
            case 'today':
                return [
                    'start' => now()->startOfDay()->format('Y-m-d'),
                    'end' => now()->endOfDay()->format('Y-m-d')
                ];
                
            case 'week':
                return [
                    'start' => now()->startOfWeek()->format('Y-m-d'),
                    'end' => now()->endOfWeek()->format('Y-m-d')
                ];
                
            case 'month':
                return [
                    'start' => now()->startOfMonth()->format('Y-m-d'),
                    'end' => now()->endOfMonth()->format('Y-m-d')
                ];
                
            case 'overdue':
                return ['start' => 'overdue'];
                
            default:
                // Assume it's a specific date
                return ['start' => $dueDateFilter];
        }
    }

    /**
     * Get task statistics
     */
    public function getTaskStats(): array
    {
        return [
            'total' => Task::count(),
            'completed' => Task::where('is_completed', true)->count(),
            'pending' => Task::where('is_completed', false)->count(),
            'high_priority' => Task::where('priority', 'high')
                                 ->where('is_completed', false)
                                 ->count(),
            'overdue' => Task::where('due_date', '<', now())
                            ->where('is_completed', false)
                            ->count()
        ];
    }
}