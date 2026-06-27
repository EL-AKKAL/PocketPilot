<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInitialCategoriesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'income' => ['array'],
            'income.*' => ['string'],
            'expense' => ['array'],
            'expense.*' => ['string'],
        ];
    }
}
