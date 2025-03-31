<?php

namespace App\Http\Requests\Api\Comment;

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
            'post' => 'nullable|string',
            'content' => 'nullable|string',
            'author' => 'nullable|string',
            'status' => 'nullable|string',
            'parent' => 'nullable|string',
            'like' => 'nullable|integer',
        ];
    }
}
