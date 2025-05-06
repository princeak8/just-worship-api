<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateCenter extends BaseRequest
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
            "location" => "nullable|string",
            "description" => "nullable|string",
            "address" => "nullable|string",
            "photo" => "nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "latitude" => "nullable|numeric",
            "longitude" => "nullable|numeric"
        ];
    }
}
