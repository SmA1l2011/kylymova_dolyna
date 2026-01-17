<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            "product_id" => ["required", "integer", "max:999999999"],
            "user_id" => ["required", "integer", "max:999999999"],
            "rating" => ["required", "integer", "max:6"],
            "comment" => ["required", "string", "max:999999"],
        ];
    }

    public function messages()
    {
        return [
            "product_id" => "product_id є обов'язковим і не повинен перевищувати 11 символів",
            "user_id" => "user_id є обов'язковим і не може містити більше 11 символів",
            "rating" => "рейтинг є обов'язковим і не повинен перевищувати 6 символів",
            "comment" => "коментар є обов'язковим і не повинен перевищувати 999999 символів",
        ];
    }
}
