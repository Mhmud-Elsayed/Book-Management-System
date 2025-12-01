<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArabicAuthorResource extends JsonResource
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
            'الاسم' => $this->name_ar,
            'السيرة' => $this->bio_ar,
            'البريد الإلكتروني' => $this->email,

        ];
    }
}
