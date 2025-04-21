<?php

namespace App\Http\Requests\Client\Post;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string',
        ];
    }

    protected function passedValidation()
    {
        return $this->merge([
           'profile_id' => auth()->user()->profile->id,
        ]);
    }
}
