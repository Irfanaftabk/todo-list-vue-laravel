<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Task Routes
Route::prefix('tasks')->group(function () {
    // List all tasks with optional filters
    Route::get('/', [TaskController::class, 'index']);
    
    // Create a new task
    Route::post('/', [TaskController::class, 'store']);

    Route::get('/stats', [TaskController::class, 'stats']);
    
    // Get a specific task
    Route::get('/{task}', [TaskController::class, 'show']);
    
    // Update a task
    Route::put('/{task}', [TaskController::class, 'update']);
    
    // Delete a task
    Route::delete('/{task}', [TaskController::class, 'destroy']);
    
    // Toggle task completion status
    Route::patch('/{task}/toggle-complete', [TaskController::class, 'toggleComplete']);
});

// Category Routes
Route::prefix('categories')->group(function () {
    // List all categories
    Route::get('/', [CategoryController::class, 'index']);
    
    // Create a new category
    Route::post('/', [CategoryController::class, 'store']);
    
    // Get a specific category with its tasks
    Route::get('/{category}', [CategoryController::class, 'show']);
    
    // Update a category
    Route::put('/{category}', [CategoryController::class, 'update']);
    
    // Delete a category
    Route::delete('/{category}', [CategoryController::class, 'destroy']);
});

// API Documentation route for OpenAPI/Swagger (if needed in future)
// Route::get('/docs', fn() => response()->file(public_path('api-docs.json')));

// Health check endpoint for monitoring
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});