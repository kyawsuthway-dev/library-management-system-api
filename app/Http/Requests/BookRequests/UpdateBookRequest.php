<?php

namespace App\Http\Requests\BookRequests;

use Illuminate\Foundation\Http\FormRequest;

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
}
