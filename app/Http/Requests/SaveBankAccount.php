<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

use Illuminate\Validation\Rule;

use App\EnumClass;

class SaveBankAccount extends BaseRequest
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
            "type" => ["nullable", Rule::in(EnumClass::bankAccountTypes())],
            "countryId" => "nullable|integer|exists:countries,id",
            "currency" => "nullable|string",
            "bankId" => "nullable|integer|exists:banks,id",
            "name" => "required|string",
            "number" => "required|string",
            "swift_bic" => "nullable|string"
        ];
    }
}
