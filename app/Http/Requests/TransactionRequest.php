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
            'amount' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'category' => ['required', 'string', 'exists:categories,value'],
        ];
    }
}
