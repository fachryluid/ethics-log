<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSubmitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:32',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|regex:/^[a-zA-Z0-9_]+$/|unique:users,username',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
