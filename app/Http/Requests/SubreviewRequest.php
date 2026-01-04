<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubreviewRequest extends FormRequest
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
            "review_id" => ["required", "integer", "max:999999999"],
            "user_id" => ["required", "integer", "max:999999999"],
            "rating" => ["required", "integer", "max:6"],
            "comment" => ["required", "string", "max:999999"],
        ];
    }

    public function messages()
    {
        return [
            "product_id" => "product_id is required and has to be no more than 11",
            "review_id" => "review_id is required and has to be no more than 11",
            "user_id" => "user_id is required and has to be no more than 11",
            "rating" => "rating is required and has to be no more than 6",
            "comment" => "comment is required and has to be no more than 999999",
        ];
    }
}
