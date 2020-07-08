<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class CreateProductRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'offer_id' => 'exists:offers,id|required',
            'product' => 'array|min:1|required',
            'product.*' => 'array|min:3',
            'product.*.name' => 'string|min:3|required',
            'product.*.qty' => 'numeric|required',
            'product.*.price' => 'numeric|required'
        ];
    }
}
