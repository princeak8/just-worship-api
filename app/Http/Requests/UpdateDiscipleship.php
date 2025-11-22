<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateDiscipleship extends BaseRequest
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
            "name" => "nullable|string",
            "month" => ["nullable", "regex:/^(0[1-9]|1[0-2])$/"],
            "year" => ["nullable", "integer", "min:1900", "max:2100"],
            "countryId" => "nullable|exists:countries,id",
            "venue" => "nullable|string",
            "online" => "nullable|boolean",
            "link" => "nullable|url",
            "open" => "nullable|boolean",
            "deadline" => "nullable|date|after:today"
        ];
    }
}
