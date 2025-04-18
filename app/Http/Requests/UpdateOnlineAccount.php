<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateOnlineAccount extends BaseRequest
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
            "qrCodePhoto" => "nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "name" => "nullable|string",
            "url" => "nullable|string|unique:online_accounts,url"
        ];
    }
}
