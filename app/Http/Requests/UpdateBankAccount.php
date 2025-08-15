<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

use Illuminate\Validation\Rule;

use App\EnumClass;

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
            "type" => ["nullable", Rule::in(EnumClass::bankAccountTypes())],
            "countryId" => "nullable|integer|exists:countries,id",
            "currency" => "nullable|string",
            "bankId" => "nullable|exists:banks,id",
            "name" => "nullable|string",
            "number" => "nullable|string",
            "swift_bic" => "nullable|string"
        ];
    }
}
