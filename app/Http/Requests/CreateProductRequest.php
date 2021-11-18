<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'product_name' => 'required',
            'product_description' => 'required',
        ];
    }

    public function getProductName()
    {
        return $this->input('product_name', null);
    }

    public function getProductDescription()
    {
        return $this->input('product_description', null);
    }
}
