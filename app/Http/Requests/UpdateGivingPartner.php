<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Http\Requests\BaseRequest;

use App\EnumClass;

class UpdateGivingPartner extends BaseRequest
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
            'firstname' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => ['required', 'email','max:255',
                Rule::unique('giving_partners', 'email')->where(function ($query) {
                    return $query->where('recurrent', $this->boolean('recurrent'))->where("id", "!=", $this->route('partnerId') );
                })->when($this->boolean('recurrent'), function ($rule) {
                    return $rule->where('recurrent', true);
                })
            ],
            'phone' => ['required', 'string','max:20',
                Rule::unique('giving_partners')->where(function ($query) {
                    return $query->where('country_id', $this->countryId)
                                 ->where('recurrent', $this->boolean('recurrent'))->where("id", "!=", $this->route('partnerId') );
                })->when($this->boolean('recurrent'), function ($rule) {
                    return $rule->where('recurrent', true);
                })
            ],
            'countryId' => 'required|string|size:2|exists:countries,code',
            'givingOptionId' => 'nullable|integer|exists:giving_options,id',
            'recurrent' => 'boolean',
            'recurrentType' => ['nullable', 'string',
                Rule::in(EnumClass::givingRecurrentTypes()),
                Rule::requiredIf($this->boolean('recurrent'))
            ],
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'prayerPoint' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'This email is already registered for recurring donations.',
            'phone.unique' => 'This phone number is already registered for recurring donations.',
            'recurrentType.required' => 'Recurrent type is required when recurrent is selected.',
            'givingOptionId.exists' => 'The selected giving option does not exist.',
            'countryId.exists' => 'The selected country does not exist.',
            'amount.min' => 'Amount must be at least 0.01.',
            'amount.max' => 'Amount cannot exceed 999,999.99.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'recurrent' => $this->boolean('recurrent'),
        ]);
    }
}
