<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateSlide extends BaseRequest
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
            "title" => "nullable|string",
            "photo" => "nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "message" => "nullable|string",
            "buttonText" => "nullable|string",
            "buttonUrl" => "nullable|string"
        ];
    }
}
