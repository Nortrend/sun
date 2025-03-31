<?php


namespace App\Http\Requests\Admin\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string',
            'commentable_type' => 'required|string|in:App\\Models\\Post,App\\Models\\Article',
            'commentable_id' => 'required|integer',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ];
    }
}
