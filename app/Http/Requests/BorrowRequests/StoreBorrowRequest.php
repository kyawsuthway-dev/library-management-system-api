<?php

namespace App\Http\Requests\BorrowRequests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StoreBorrowRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'books' => 'required|array',
            'books.*' => 'exists:books,id',
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
