<?php
namespace App\Http\Requests\Api\Article;

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
            'title'                => ['nullable', 'string', 'max:255'],
            'profile_name'         => ['nullable', 'string', 'exists:profiles,name'],
            'category_title'       => ['nullable', 'string', 'exists:categories,title'],
            'published_at_from'    => ['nullable', 'date_format:Y-m-d'],
            'published_at_to'      => ['nullable', 'date_format:Y-m-d'],
        ];
    }

    public function filters(): array
    {
        return $this->only([
            'title',
            'profile_name',
            'category_title',
            'published_at_from',
            'published_at_to',
        ]);
    }
}
