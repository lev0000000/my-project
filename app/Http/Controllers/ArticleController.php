<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'q' => 'nullable|string|max:255',
            'author_id' => 'nullable|integer|exists:authors,id',
            'category_id' => 'nullable|integer|exists:categories,id',
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_by' => 'sometimes|in:id,title,created_at',
            'sort_dir' => 'sometimes|in:asc,desc',
        ]);

        $query = Article::query()
            ->with(['author', 'categories']);

        $search = trim($data['q'] ?? '');

        if ($search !== '') {
            $query->where('title', 'like', "%{$search}%");

            $query->orderByRaw(
                'CASE
                    WHEN title = ? THEN 0
                    WHEN title LIKE ? THEN 1
                    ELSE 2
                END',
                [$search, "{$search}%"]
            );
        }

        if (isset($data['author_id'])) {
            $query->where('author_id', $data['author_id']);
        }

        if (isset($data['category_id'])) {
            $categoryIds = Category::descendantsAndSelf(
                $data['category_id']
            )->pluck('id');

            $query->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }

        $query->orderBy(
            $data['sort_by'] ?? 'created_at',
            $data['sort_dir'] ?? 'desc'
        )->orderBy('id');

        return ArticleResource::collection(
            $query->paginate($data['per_page'] ?? 20)
                ->withQueryString()
        );
    }

    public function show(Article $article)
    {
        return new ArticleResource(
            $article->load(['author', 'categories'])
        );
    }

    public function showBySlug(string $slug)
    {
        $article = Article::with(['author', 'categories'])
            ->where('slug', $slug)
            ->firstOrFail();

        return new ArticleResource($article);
    }
}
