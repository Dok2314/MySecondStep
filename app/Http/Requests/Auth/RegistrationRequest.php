<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'                  => ['required', 'string', 'min:3', 'max:255'],
            'email'                 => ['required', 'unique:users', 'email' => 'email:rfc,dns', 'min:5', 'max:255'],
            'password'              => ['required', 'max:255', Password::defaults(), 'confirmed'],
            'password_confirmation' => ['required'],
            'captcha'               => ['required', 'captcha']
        ];
    }

    public function messages()
    {
        return [
            'captcha.captcha' => 'Enter valid captcha code shown in image'
        ];
    }
}
