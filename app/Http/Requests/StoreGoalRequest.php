<?php

namespace App\Http\Requests;

use App\Enums\GoalPeriodEnum;
use App\Enums\GoalTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreGoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => ['required', 'numeric', 'between:5,999999.99'],
            'period' => ['required', new Enum(GoalPeriodEnum::class)],
            'type' => ['required', new Enum(GoalTypeEnum::class)],
        ];
    }
}
