<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PeriodicTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
        ]);
    }

    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|between:-999999,999999',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
            'category' => ['required', 'string', 'exists:categories,id'],
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];
    }
}
