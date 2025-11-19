<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * For now, anyone (guest or logged in) can checkout.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'payment_method'   => 'required|in:khqr',
        ];
    }

    /**
     * Custom error messages (optional).
     */
    public function messages(): array
    {
        return [
            'shipping_name.required'    => 'Please enter your full name.',
            'shipping_name.string'      => 'Name must be a valid string.',
            'shipping_name.max'         => 'Name may not exceed 255 characters.',

            'shipping_phone.required'   => 'Please enter your phone number.',
            'shipping_phone.string'     => 'Phone number must be a valid string.',
            'shipping_phone.max'        => 'Phone number may not exceed 50 characters.',

            'shipping_address.required' => 'Please enter your shipping address.',
            'shipping_address.string'   => 'Address must be a valid string.',

            'payment_method.required'   => 'Please select a payment method.',
            'payment_method.in'         => 'Invalid payment method selected.',
        ];
    }
}