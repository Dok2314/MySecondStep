<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'slug'  => ['unique:posts'],
            'post'  => ['required', 'string', 'min:5', 'max:1500']
        ];
    }
}
