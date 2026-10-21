<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Список категорий с пагинацией
    public function index(Request $request)
    {
        $data = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
        ]);

        $categories = Category::query()
            ->withCount('articles')
            ->orderBy('id')
            ->paginate($data['per_page'] ?? 20);

        return CategoryResource::collection($categories);
    }

    // Полное дерево категорий
    public function tree()
    {
        $categories = Category::defaultOrder()
            ->get()
            ->toTree();

        return CategoryResource::collection($categories);
    }

    // Получение категории по ID
    public function show(Category $category)
    {
        $category->load('children')->loadCount('articles');

        return new CategoryResource($category);
    }

    // Получение категории по slug
    public function showBySlug(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->firstOrFail();

        $category->load('children')->loadCount('articles');

        return new CategoryResource($category);
    }
}
