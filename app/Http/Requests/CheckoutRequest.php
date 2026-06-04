<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'phone' => ['required', 'string', 'regex:/^0[67]\d{8}$/'],
            'payment_method' => ['required', 'string', 'in:cod'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => trans('checkout.validation.email.required'),
            'first_name.required' => trans('checkout.validation.first_name.required'),
            'last_name.required' => trans('checkout.validation.last_name.required'),
            'address.required' => trans('checkout.validation.address.required'),
            'city.required' => trans('checkout.validation.city.required'),
            'postal_code.required' => trans('checkout.validation.postal_code.required'),
            'phone.required' => trans('checkout.validation.phone.required'),
            'phone.regex' => trans('checkout.validation.phone.regex'),
        ];
    }
}
