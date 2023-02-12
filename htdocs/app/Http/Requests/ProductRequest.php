<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
           'product_name'       => ['required', 'string', 'max:50'],
           'picture'            => ['nullable', 'image', 'max:150000'],
           'category_id'        => ['required', 'integer', 'exists:categories,id'],
           'manufacturer_id'    => ['required', 'integer', 'exists:manufacturers,id'],
           'price'              => ['required', 'integer'],
           'is_selling'         => ['boolean'],
           'memo'               => ['string', 'nullable'],
        ];
    }
}
