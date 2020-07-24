<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateCompanyRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'company_name' => 'string|min:2|starts_with:PT.,CV.,TOKO,BPK,IBU|unique:companies,company_name,'.$this->route('id'),
            'company_tel' => 'nullable',
            'company_email' => 'email|nullable',
            'company_industry' => 'exists:industries,id',
            'company_address' => 'string'
        ];
    }
}
