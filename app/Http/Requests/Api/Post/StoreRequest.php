<?php

namespace App\Http\Requests\Api\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'content' => 'nullable|string',
            'profile_id' => 'required|integer|exists:profiles,id',
            'is_published' => 'nullable|boolean',
            'category_id' => 'required|integer|exists:categories,id',
            'views' => 'nullable|integer',
        ];
    }
}
