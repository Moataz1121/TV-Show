<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EpisodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tv_show_id' => ['required', 'integer', 'exists:tv_shows,id'],
            'title.en' => ['required', 'string', 'max:255'],
            'title.ar' => ['nullable', 'string', 'max:255'],
            'description.en' => ['required', 'string'],
            'description.ar' => ['nullable', 'string'],
            'duration' => ['required', 'integer', 'min:1'],
            'airing_time' => ['nullable', 'date'],
            'thumbnail' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
            'thumbnail_url' => ['nullable', 'string', 'max:2048'],
            'video' => ['nullable', 'file', 'mimes:mp4,mov,avi,wmv,webm,mkv', 'max:51200'],
            'video_url' => ['nullable', 'string', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'tv_show_id.required' => 'Please select a TV Show for this episode.',
            'tv_show_id.exists' => 'The selected TV Show does not exist.',
            'title.en.required' => 'The English title is required.',
            'description.en.required' => 'The English description is required.',
            'duration.required' => 'The duration in minutes is required.',
            'duration.integer' => 'The duration must be an integer.',
            'duration.min' => 'The duration must be at least 1 minute.',
        ];
    }
}
