<?php

namespace App\Http\Requests\UserRequests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'success' => false,
            'message' => $validator->errors(),
            'time' => Carbon::now()
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
