<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image,
            'excerpt' => $this->excerpt,
            'content' => $this->content,

            'author' => new AuthorResource(
                $this->whenLoaded('author')
            ),

            'categories' => CategoryResource::collection(
                $this->whenLoaded('categories')
            ),

            'created_at' => $this->created_at,
        ];
    }
}
