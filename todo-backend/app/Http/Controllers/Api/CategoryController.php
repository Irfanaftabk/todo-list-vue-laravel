<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    /**
     * List all categories
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::withCount('tasks')->get();
        
        return CategoryResource::collection($categories);
    }

    /**
     * Create a new category
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = Category::create($request->validated());
        
        return new CategoryResource($category);
    }

    /**
     * Get a specific category
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category->load('tasks'));
    }

    /**
     * Update an existing category
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $category->update($request->validated());
        
        return new CategoryResource($category);
    }

    /**
     * Delete a category
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->tasks()->detach();
        $category->delete();
        
        return response()->json(null, 204);
    }
}
