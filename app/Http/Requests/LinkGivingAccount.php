<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class LinkGivingAccount extends BaseRequest
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
            "bankAccountId" => "required_without:onlineAccountId|integer|exists:bank_accounts,id",
            "onlineAccountId" => "required_without:bankAccountId|integer|exists:online_accounts,id",
            "givingOptionId" => "required|integer|exists:giving_options,id"
        ];
    }
}
