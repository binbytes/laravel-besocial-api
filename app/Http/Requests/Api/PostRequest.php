<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'text' => [
                'required',
                'string',
            ],
        ], $this->hasMedia() ? [
            'images' => [
                'required',
                'array'
            ],
            'images.*' => [
                'required',
                'image'
            ]
        ] : []);
    }

    /**
     * @return mixed
     */
    public function hasMedia()
    {
        return $this->file('images');
    }

    /**
     * @return array
     */
    public function persist()
    {
        return $this->only('text');
    }
}
