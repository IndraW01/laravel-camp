<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id)],
            'name' => ['required'],
            'occupation' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'discount' => ['nullable', Rule::exists('discounts', 'code')->where(function ($query) {
                return $query->whereNull('deleted_at');
            })]
        ];
    }

    /*
        * Checkout Versi 1

        public function messages()
        {
            return [
                'expired.after_or_equal' => 'Expired harus berisi Bulan setelah atau sama dengan :date.'
            ];
        }

        public function attributes()
        {
            return [
                'card_number' => 'Card Number',
                'cvc' => 'CVC',
            ];
        }
    */
}
