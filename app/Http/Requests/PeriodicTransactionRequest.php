<?php

namespace App\Http\Requests;

use App\Enums\CategoryEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
            'category' => ['required', 'string', new Enum(CategoryEnum::class)],
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];
    }
}
