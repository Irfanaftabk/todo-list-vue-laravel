<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * List all tasks with optional filters
     */
    public function index(): AnonymousResourceCollection
    {
        $filters = request()->only([
            'priority',
            'is_completed',
            'due_date',
            'category_ids'
        ]);

        $tasks = $this->taskService->filterTasks($filters);

        return TaskResource::collection($tasks);
    }

    /**
     * Get task statistics
     */
    public function stats(): JsonResponse
    {
        $stats = $this->taskService->getTaskStats();
        return response()->json($stats);
    }

    /**
     * Create a new task
     */
    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = $this->taskService->createTask($request->validated());

        return new TaskResource($task);
    }

    /**
     * Get a specific task
     */
    public function show(Task $task): TaskResource
    {
        return new TaskResource($task->load('categories'));
    }

    /**
     * Update an existing task
     */
    public function update(UpdateTaskRequest $request, Task $task): TaskResource
    {
        $task = $this->taskService->updateTask($task, $request->validated());

        return new TaskResource($task);
    }

    /**
     * Delete a task
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->categories()->detach();
        $task->delete();

        return response()->json(null, 204);
    }

    /**
     * Toggle task completion status
     */
    public function toggleComplete(Task $task): TaskResource
    {
        $task->update(['is_completed' => !$task->is_completed]);

        return new TaskResource($task);
    }
}