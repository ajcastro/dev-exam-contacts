<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $contact = $this->route('contact');

        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('contacts', 'email')->ignore($contact)],
            'phone' => ['string', 'required'],
            'country' => ['string'],
            'city' => ['string'],
            'state' => [
                'string',
                function ($attribute, $value, $fail) {
                    $numberOfChars = 2;

                    if (!is_null($value) && strlen($value) != $numberOfChars) {
                        $fail("The {$attribute} should be {$numberOfChars} characters.");
                    }
                },
            ],
            'zip' => ['string'],
        ];
    }
}
