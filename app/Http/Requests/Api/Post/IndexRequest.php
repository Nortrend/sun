<?php
namespace App\Http\Requests\Api\Post;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Можно добавить логику авторизации, если нужно
    }

    public function rules(): array
    {
        return [
            'title'                => 'nullable', 'string', 'max:255',
            'profile_id'           => 'nullable', 'integer', 'exists:profiles,id',
            'category_title'       => 'nullable', 'string', 'exists:categories,id',
            'views_from'           => 'nullable', 'integer', 'min:0',
            'views_to'             => 'nullable', 'integer', 'min:0',
            'published_at_from'    => 'nullable', 'date_format:Y-m-d',
            'published_at_to'      => 'nullable', 'date_format:Y-m-d',
        ];
    }

    public function filters(): array
    {
        return $this->only(['title', 'content', 'profile_id', 'category_id', 'published_at', 'most_viewed']);
    }
}

