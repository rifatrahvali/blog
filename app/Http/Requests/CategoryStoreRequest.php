<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // validate kontrollerini yapabilmesi için : return true
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
            'name'=>['required','max:255'],
            'slug' =>['max:255'],
            'description' =>['max:255'],
            'seo_keywords' =>['max:255'],
            'seo_description' =>['max:255'],
        ];
    }

    // Hata Mesajları
    public function messages() {
        return [
            'name.required' =>  'Kategori Adı zorunludur.',
            'name.max' =>  'Kategori Adı maximum 255 karakter olmalıdır.',
            'description.max' =>  'Kategori Açıklama maximum 255 karakter olmalıdır.',
            'seo_keywords.max' =>  'Kategori Seo Kelimeleri maximum 255 karakter olmalıdır.',
            'seo_description.max' =>  'Kategori Seo açıklamaları maximum 255 karakter olmalıdır.'
        ];
    }
}
