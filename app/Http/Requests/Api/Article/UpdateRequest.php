<?php


namespace App\Http\Requests\Api\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Определяет, авторизован ли пользователь на выполнение этого запроса.
     */
//    public function authorize(): bool
//    {
//        return true; // Измени, если нужна проверка прав
//    }

    /**
     * Возвращает правила валидации.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'profile_id' => 'required|integer|exists:profiles,id',
            'category_id' => 'required|integer|exists:categories,id',
            'image_path' => 'nullable|string|max:255',
        ];
    }
}
