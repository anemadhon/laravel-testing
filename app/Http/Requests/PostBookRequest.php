<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
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
        // @TODO implement
        return [
            "isbn" => ['required', 'numeric', 'string', 'size:13', 'unique:books,isbn'],
            "title" => ['required', 'string'],
            "description" => ['required', 'string'],
            "published_year" => ['required', 'integer', 'min:1900', 'max:2020'],
            "authors" => ['required', 'array'],
            "authors.*"=> ['exists:authors,id']
        ];
    }
}
