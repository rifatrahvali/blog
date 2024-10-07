<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class ArticleCreateRequest extends FormRequest
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
            "title" => ['required', 'max:255'],
            'slug' => ['nullable', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            // 'category_id' => ['required', 'exists:categories,id'],
            // 'tags' => ['nullable', 'string'],
            // 'seo_keywords' => ['nullable', 'string'],
            // 'seo_description' => ['nullable', 'string'],
            // 'publish_date' => ['nullable', 'date'],
            // 'status' => ['boolean'],
            
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Makale Adı zorunludur.',
            'name.max' => 'Makale Adı maximum 255 karakter olmalıdır.',
            'body.required' => 'İçerik zorunludur.',
            'image.image' => 'Görsel seçiniz PNG,JPG,JPEG ve maximum 2mb olmalıdır.'
        ];
    }

}
