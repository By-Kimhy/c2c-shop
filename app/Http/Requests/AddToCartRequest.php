<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * For now, anyone (guest or logged in) can add to cart.
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
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer|min:1|max:100',
        ];
    }

    /**
     * Custom error messages (optional).
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'A product must be selected.',
            'product_id.exists'   => 'The selected product does not exist.',
            'quantity.required'   => 'Please enter a quantity.',
            'quantity.integer'    => 'Quantity must be a number.',
            'quantity.min'        => 'Quantity must be at least 1.',
            'quantity.max'        => 'Quantity may not exceed 100.',
        ];
    }
}