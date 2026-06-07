<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'nullable|string',
            'amount' => ['required', 'numeric', 'between:-999999,999999'],
            'category_id' => ['required', 'string', 'exists:categories,id'],
        ];
    }
}
