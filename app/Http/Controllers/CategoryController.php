<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequests\StoreCategoryRequest;
use App\Http\Requests\CategoryRequests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();

            return $this->apiResponseSuccess('Categories retrieved successfully!', CategoryResource::collection($categories), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $validated_request = $request->safe();

            $category = Category::create($validated_request->toArray());

            return $this->apiResponseSuccess('Category created successfully!', new CategoryResource($category), 201);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
    
    public function show(Category $category)
    {
        return $this->apiResponseSuccess('Category retrieved successfully!', new CategoryResource($category), 200);
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        try {
            $validated_request = $request->safe();

            $category->update($validated_request->toArray());

            return $this->apiResponseSuccess('Category updated successfully!', new CategoryResource($category), 200);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return $this->apiResponseSuccess('Category removed!', null, 204);
        } catch (\Throwable $th) {
            return $this->apiResponseError($th->getMessage(), 500);
        }
    }
}
