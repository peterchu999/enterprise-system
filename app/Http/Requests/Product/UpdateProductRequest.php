<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateProductRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'offer_id' => 'exists:offers,id',
            'name' => 'string|min:3',
            'qty' => 'numeric',
            'price' => 'numeric'
        ];
    }
}
