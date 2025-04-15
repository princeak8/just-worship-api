<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class SaveAbout extends BaseRequest
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
            "mission" => "nullable|string|required_with:missionPhoto",
            "missionPhoto" => "required_with:mission|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "vision" => "nullable|string|required_with:visionPhoto",
            "visionPhoto" => "required_with:vision|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "pastorPhoto" => "nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "header" => "nullable|string",
            "content" => "nullable|string",
            "pastorTitle" => "nullable|string",
            "pastorBio" => "nullable|string"
        ];
    }
}
