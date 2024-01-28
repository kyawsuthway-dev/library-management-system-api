<?php

namespace App\Http\Requests\BookRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'publisher_id' => 'required|integer|exists:publishers,id',
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string',
            'pages' => 'required|integer',
            'quantity' => 'required|integer',
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
        ];
    }
}
