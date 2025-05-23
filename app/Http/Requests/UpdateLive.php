<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateLive extends BaseRequest
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
            "title" => [
                "nullable",
                "string",
                Rule::unique("lives", "title")->ignore($this->route("id"))
            ],
            "url" => [
                "nullable",
                "string",
                Rule::unique("lives", "url")->ignore($this->route("id"))
            ],
            "liveDate" => "nullable|date|date_format:Y-m-d|after:yesterday",
            "liveTime" => "nullable|date_format:h:i A",
            "coverPhoto" => "nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "minister" => "nullable|string",
            "description" => "nullable|string"
        ];
    }
}
