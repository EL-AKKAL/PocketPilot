<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('accounts')
                ->where(fn ($q) => $q->where('user_id', auth()->id())), ],
            'starting_balance' => ['required', 'numeric'],
        ];
    }
}
