<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

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
    public function rules(Request $request): array
    {
        if (auth()->user() == null) {
            return [
                "order" => ["required"],
                "user_info" => ["required", "string", "max:255"],
            ];
        } else {
            return [
                "order" => ["required"],
            ];
        }
    }

    public function messages()
    {
        return [
            "user_info" => "ви не вказали контактну інформацію",
        ];
    }
}
