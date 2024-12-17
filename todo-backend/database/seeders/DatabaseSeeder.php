<?php

namespace Database\Seeders;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tasks = [
            [
                'description' => 'Complete project documentation',
                'due_date' => now()->addDays(7),
                'priority' => 'high',
                'is_completed' => false,
            ],
            [
                'description' => 'Review pull requests',
                'due_date' => now()->addDays(2),
                'priority' => 'medium',
                'is_completed' => false,
            ],
            [
                'description' => 'Setup development environment',
                'due_date' => now()->subDays(1),
                'priority' => 'high',
                'is_completed' => true,
            ],
            [
                'description' => 'Plan team meeting',
                'due_date' => now()->addDays(3),
                'priority' => 'low',
                'is_completed' => false,
            ],
            [
                'description' => 'Update dependencies',
                'due_date' => now()->addWeek(),
                'priority' => 'medium',
                'is_completed' => false,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }

        $categories = [
            'Work' => [1, 2, 5],
            'Personal' => [4],
            'Development' => [3, 5],
            'Meetings' => [4],
            'Documentation' => [1],
        ];

        foreach ($categories as $name => $taskIds) {
            $category = Category::create(['name' => $name]);
            $category->tasks()->attach($taskIds);
        }
    }
}
