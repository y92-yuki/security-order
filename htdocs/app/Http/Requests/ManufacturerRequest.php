<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Manufacturer;

class ManufacturerRequest extends FormRequest
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
            'manufacturer_name' => ['required', 'string', 'max:50', 'unique:'.Manufacturer::class],
            'picture' => ['nullable', 'image', 'max:150000'],
            'other' => ['nullable', 'string'],
        ];
    }
}
