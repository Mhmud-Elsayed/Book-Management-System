<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArabicBooksResource extends JsonResource
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
            'العنوان' => $this->title_ar,
            'الوصف' => $this->description_ar,
            'السعر' => $this->price,
            'المؤلف' => new ArabicAuthorResource($this->whenLoaded('author')),
        ];
    }
}
