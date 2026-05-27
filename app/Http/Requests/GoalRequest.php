<?php

namespace App\Http\Requests;

use App\Enums\GoalPeriodEnum;
use App\Enums\GoalStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class GoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => ['required', 'numeric', 'min:0.01'],
            'period' => ['required', new Enum(GoalPeriodEnum::class)],
            'status' => ['nullable', new Enum(GoalStatusEnum::class)],
        ];
    }
}
