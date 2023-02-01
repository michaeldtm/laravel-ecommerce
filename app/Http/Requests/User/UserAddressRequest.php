<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required_without:default_address', 'string', 'max:255'],
            'phone' => ['string', 'max:25'],
            'address_1' => ['required_without:default_address', 'string'],
            'address_2' => ['string'],
            'city' => ['required_without:default_address', 'string', 'max:30'],
            'state' => ['required_without:default_address', 'string', 'max:30'],
            'zipcode' => ['string', 'max:10'],
            'default_address' => ['boolean'],
        ];
    }
}
