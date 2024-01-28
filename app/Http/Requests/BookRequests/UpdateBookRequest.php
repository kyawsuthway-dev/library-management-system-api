<?php

namespace App\Http\Requests\BookRequests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateBookRequest extends FormRequest
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
            'publisher_id' => 'integer|exists:publishers,id',
            'category_id' => 'integer|exists:categories,id',
            'title' => 'string',
            'pages' => 'integer',
            'quantity' => 'integer',
            'authors' => 'array',
            'authors.*' => 'exists:authors,id',
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
