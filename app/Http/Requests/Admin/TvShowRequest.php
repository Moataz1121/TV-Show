<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TvShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title.en' => ['required', 'string', 'max:255'],
            'title.ar' => ['nullable', 'string', 'max:255'],
            'description.en' => ['required', 'string'],
            'description.ar' => ['nullable', 'string'],
            'airing_time' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.en.required' => 'The English title is required.',
            'description.en.required' => 'The English description is required.',
        ];
    }
}
