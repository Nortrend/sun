<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Support\Facades\Storage;

class UpdateRequest extends StoreRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);
    }

    public function passedValidation()
    {
        $imagePath = null;

        try {
            if ($this->hasFile('image')) {
                $file = $this->file('image');
                $storedPath = Storage::disk('public')->putFile('images', $file);

                if ($storedPath && is_string($storedPath)) {
                    $imagePath = $storedPath;
                } else {
                    throw new \Exception('Файл не сохранён.');
                }
            }
        } catch (\Throwable $e) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'image' => 'Не удалось загрузить изображение: ' . $e->getMessage(),
            ]);
        }

        $this->merge([
            'image_path' => $imagePath,
        ]);
    }

}
