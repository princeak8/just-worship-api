<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateBankAccount extends BaseRequest
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
            "countryId" => "nullable|integer|exists:countries,id",
            "currency" => "nullable|string",
            "bank" => "nullable|string",
            "name" => "nullable|string",
            "number" => "nullable|string"
        ];
    }
}
