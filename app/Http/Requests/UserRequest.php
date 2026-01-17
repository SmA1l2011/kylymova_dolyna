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
            "name" => "ім'я є обов'язковим і не повинно перевищувати 255 символів",
            "surname" => "прізвище не повинно містити більше 255 символів",
            "email" => "електронна адреса є обов'язковою і не повинна перевищувати 255 символів",
            "phone" => "телефон є обов'язковим і не повинен містити більше 255 символів",
            "password" => "password has to be no more than 255",
            "role" => "роль є обов'язковою і не повинна перевищувати 255",
        ];
    }
}
