<?php

namespace App\Http\Requests\Offer;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class CreateOfferRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'status' => 'digits_between:1,3|nullable',
            'company_id' => 'exists:companies,id|required',
            'offer_date' => 'date|required',
            'information' => 'string|min:5|required',
            'purchase_order' => 'string|nullable',
            'product' => 'array|min:1|nullable',
            'product.*' => 'array|min:3',
            'product.*.name' => 'string|min:3|required',
            'product.*.qty' => 'numeric|required',
            'product.*.price' => 'numeric|required'
        ];
    }
}