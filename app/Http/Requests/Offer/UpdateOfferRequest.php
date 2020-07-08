<?php

namespace App\Http\Requests\Offer;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateOfferRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'status' => 'digits_between:1,3|nullable|required_with:product',
            'company_id' => 'exists:companies,id',
            'information' => 'string|min:3',
            'offer_date' => 'date',
            'purchase_order' => 'string|nullable',
            'product' => 'array|min:1|nullable',
            'product.*' => 'array|min:3',
            'product.*.name' => 'string|min:3|required',
            'product.*.qty' => 'numeric|required',
            'product.*.price' => 'numeric|required'
        ];
    }
}