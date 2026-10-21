<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'last_name' => $this->last_name,
            'avatar' => $this->avatar,
            'birth_year' => $this->birth_year,
            'biography' => $this->biography,
            'slug' => $this->slug,
        ];
    }
}
