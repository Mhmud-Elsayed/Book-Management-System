<?php

namespace App\Http\Requests\BookRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title_en" => "required|string|max:255",
            "title_ar" => "required|string|max:255",
            "description_en" => "required|string",
            "description_ar" => "required|string",
            "price" => "required|numeric|min:0",
            "author_id" => "required|exists:authors,id",    
            
        ];
    }
}
