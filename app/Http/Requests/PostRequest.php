<?php

namespace App\Http\Requests;

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
        return [
            'title' =>  ['required'],
            'name' =>  ['required'],
            'description' =>  ['required'],
            'is_active' =>  ['required'],
            'publish_date' =>  ['required'],
            'category_id' =>  ['required'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'         =>  "The Title Field Is Required",
            'name.required'        =>  "The Author Name Field Is Required",
            'description.required'        =>  "The Description Field Is Required",
            'is_active.required'        =>  "The Staut Field Is Required",
            'publish_date.required'        =>  "The Publishable Date Field Is Required",
            'category_id.required'        =>  "The Category Name Field Is Required",
        ];
    }
}
