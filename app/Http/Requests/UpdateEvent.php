<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class UpdateEvent extends BaseRequest
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
            "name" => [
                "nullable",
                "string",
                Rule::unique("events", "name")->ignore($this->route("eventId"))
            ],
            "eventDate" => "nullable|date",
            "eventTime" => "nullable|date_format:h:i A",
            "location" => "nullable|string",
            "coverPhoto" => "nullable|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "content" => "nullable|string",
            "featured" => "nullable|boolean"
        ];
    }
}
