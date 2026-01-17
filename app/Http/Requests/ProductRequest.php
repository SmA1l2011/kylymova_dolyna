<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class ProductRequest extends FormRequest
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
        return [
            "subcategory_id" => ["required", "integer", "exists:subcategories,id"],
            "title" => ["required", "string", "max:255"],
            "price" => ["required", "numeric", "max:999999"],
            "picture" => ["image", "mimes:jpg,jpeg,png,webp"],
        ];
    }

    public function messages()
    {
        return [
            "subcategory_id" => "ідентифікатор підкатегорії є обов'язковим і не повинен перевищувати 11 символів",
            "title" => "заголовок є обов'язковим і не повинен перевищувати 255 символів",
            "price" => "ціна є обов'язковою і не повинна перевищувати 999999",
            "picture" => "фотографія є обов'язковою і повинна бути у форматі jpg, jpeg, png або webp",
        ];
    }
}
