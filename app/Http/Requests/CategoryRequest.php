<?php

namespace App\Http\Requests;

use App\Enums\TypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')
                    ->where(fn ($query) => $query->where(
                        'account_id',
                        Auth::user()->account->id
                    ))
                    ->ignore($category),
            ],

            'type' => ['required', new Enum(TypeEnum::class)],
        ];
    }
}
