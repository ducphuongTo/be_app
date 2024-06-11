<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            //
            "product_name" => "required|min:10|max:128",
            "product_thumbnail" => 'required',
            "product_images" => 'required',
            "product_price" => "required",
            "product_quantity" => "required",
            "category_id" => "required",
            "brand_id" => "required",
            "discount_id" => "required",
            "sku" =>"nullable",
            "desc"=>"nullable"

        ];
    }
    public function messages()
    {
        return [
            "required" => ":Attribute is required!",

        ];
    }
}
