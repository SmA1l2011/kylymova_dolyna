<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('id');
        return [
            "name" => ["required", "string", "max:255"],
            "surname" => ["nullable", "string", "max:255"],
            "email" => ["required", Rule::unique('users', 'email')->ignore($userId), "max:255"],
            "phone" => ["required", Rule::unique('users', 'phone')->ignore($userId), "max:255"],
            "password" => ["nullable", "string", "max:255"],
            "role" => ["required", "string", "max:255"],
        ];
    }

    public function messages()
    {
        return [
            "name" => "name is required and has to be no more than 255",
            "surname" => "surname has to be no more than 255",
            "email" => "email is required and has to be no more than 255",
            "phone" => "phone is required and has to be no more than 255",
            "password" => "password has to be no more than 255",
            "role" => "role is required and has to be no more than 255",
        ];
    }
}
