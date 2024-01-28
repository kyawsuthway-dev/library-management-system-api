<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'max:100',
            'last_name' => 'max:100',
            'email' => 'email|max:255|unique:users,email',
            'user_type_id' => 'integer|exists:user_types,id',
            'status' => [Rule::in(['active', 'inactive'])]
        ];
    }
}
