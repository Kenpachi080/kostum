<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'phone' => 'required|unique:users,phone',
            'fio' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'phone.unique' => 'Данный телефон занят',
            'email.required' => 'Данная почта занята',
        ];
    }
}
