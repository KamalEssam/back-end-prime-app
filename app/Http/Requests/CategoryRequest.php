<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if ($this->method() == 'POST') {
            return [
                'en_name' => 'required|unique:categories,en_name',
//                'ar_name' => 'required|unique:categories,ar_name',
                'image' => 'required',
            ];
        }
        return [
            'en_name' => 'required|unique:categories,en_name,' . $this->id,
//            'ar_name' => 'required|unique:categories,ar_name,' . $this->id,
        ];

    }
}
