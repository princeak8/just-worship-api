<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class AddEvent extends BaseRequest
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
            "name" => "required|string|unique:events,name",
            "eventDate" => "required|date",
            "eventTime" => "nullable|date_format:h:i A",
            "location" => "nullable|string",
            "coverPhoto" => "required|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "content" => "nullable|string",
            "featured" => "nullable|boolean"
        ];
    }
}
