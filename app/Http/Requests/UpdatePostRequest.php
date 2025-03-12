<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max:60',
            'content' => 'required',
            'status' => 'required|in:draft,published,scheduled',
            'publish_date' => 'nullable|date',
        ];
    }
}
