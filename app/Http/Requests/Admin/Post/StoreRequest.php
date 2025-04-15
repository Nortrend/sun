<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

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
            'title'=> 'required|string',
            'content'=> 'nullable|string',
            'category_id'=> 'required|integer|exists:categories,id',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'integer|exists:tags,id',

        ];
    }

    public function passedValidation()
    {
        if (!auth()->user()?->profile) {
            throw new \Exception('Профиль пользователя не найден.');
        }

        $imagePath = null;

        if ($this->hasFile('image')) {
            $file = $this->file('image');
            $storedPath = Storage::disk('public')->putFile('images', $file);

            if ($storedPath && is_string($storedPath)) {
                $imagePath = $storedPath;
            } else {
                throw new \Exception('Ошибка при сохранении изображения.');
            }
        }

        $this->merge([
            'profile_id' => auth()->user()->profile->id,
            'image_path' => $imagePath,
        ]);
    }
     public function messages(){
         return [
             'title.required' => 'Это поле обязательно к заполнению!',
             'category_id.required' => 'Это поле обязательно к заполнению!'
         ];
     }

}
