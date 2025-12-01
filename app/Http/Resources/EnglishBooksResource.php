<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnglishBooksResource extends JsonResource
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
            'title' => $this->title_en,
            'description' => $this->description_en,
            'price' => $this->price,
            'author' => new EnglishAuthorResource($this->whenLoaded('author')),
        ];
    }
}
