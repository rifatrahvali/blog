<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            // users tablosuna bakacak geçerli mail  var mı ?
            "email" =>["email","exists:users","required"],
            "password" => ["required"],
        ];
    }

    public function messages(){
        return [
            'email.exists' => 'Email veya Parola Hatalıdır.',
            'email.required' => 'Email zorunludur.',
            'password.required' => 'Parola zorunludur.'
        ];
    }
}
