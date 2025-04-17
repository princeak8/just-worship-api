<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class AddLive extends BaseRequest
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
            "title" => "required|string|unique:lives,title",
            "url" => "required|string|unique:lives,url",
            "liveDate" => "nullable|date|date_format:Y-m-d|after:yesterday",
            "liveTime" => "nullable|date_format:h:i",
            "coverPhoto" => "required|image|mimes:jpg,jpeg,png,gif,webp|max:10024",
            "description" => "nullable|string"
        ];
    }
}
