<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class CreateDiscipleship extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string",
            "month" => ["required", "regex:/^(0[1-9]|1[0-2])$/"],
            "year" => ["required", "integer", "min:1900", "max:2100"],
            "open" => "nullable|boolean",
            "photo" => "nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "countryId" => "nullable|exists:countries,id",
            "venue" => "nullable|string",
            "online" => "nullable|boolean",
            "link" => "nullable|url",
            "deadline" => "nullable|date|after:today"
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $month = (int) $this->input('month');
            $year = (int) $this->input('year');

            $currentYear = (int) date('Y');
            $currentMonth = (int) date('m');

            if ($year < $currentYear || ($year === $currentYear && $month < $currentMonth)) {
                $validator->errors()->add(
                    'month',
                    'The selected month and year must not be in the past.'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            "month.regex" => "The month must be in format 01-12 (e.g., 01, 02, 03...12)"
        ];
    }
}
