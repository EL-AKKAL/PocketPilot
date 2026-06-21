<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DebtRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'nullable|string',
            'amount' => ['required', 'numeric', 'between:0,999999'],
        ];
    }
}
