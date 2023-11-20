<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'phone_number' => 'required|string',
            'payment_method' => 'string|required',
            'address' => 'required|string',
            'products' => 'array',
            'user_id' => 'integer',
            'user_name' => 'string|required',
            'email' => 'string|email|required',
            'stock' => 'integer',
            'status' => 'string|nullable',
            'payment_status' => 'string|nullable'
        ];
    }
    public function messages(): array
    {
        return [
            'phone_number.required' => 'phone number is required',
            'address.required' => 'address is required',
            'email.email' => 'email must be a valid email address',
        ];
    }
}
