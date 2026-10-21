<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'last_name' => 'nullable|string|max:100',
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_by' => 'sometimes|in:id,full_name,birth_year',
            'sort_dir' => 'sometimes|in:asc,desc',
        ]);

        $authors = Author::query()
            ->when(
                !empty($data['last_name']),
                fn ($query) => $query->where(
                    'last_name',
                    'like',
                    '%' . $data['last_name'] . '%'
                )
            )
            ->orderBy(
                $data['sort_by'] ?? 'id',
                $data['sort_dir'] ?? 'asc'
            )
            ->paginate($data['per_page'] ?? 20)
            ->withQueryString();

        return AuthorResource::collection($authors);
    }

    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    public function showBySlug(string $slug)
    {
        $author = Author::where('slug', $slug)->firstOrFail();

        return new AuthorResource($author);
    }
}
