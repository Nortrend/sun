<?php

namespace App\Http\Requests\Admin\RoleUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'role_id' => ['required', 'exists:roles,id',
                Rule::unique('role_user')->where(function ($query) {
                    return $query->where('user_id', $this->user_id);
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'role_id.unique' => 'Эта роль уже назначена этому пользователю.',
        ];
    }
}
