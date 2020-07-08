<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateCompanyRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'company_name' => 'string|min:5|unique:companies,company_name,'.$this->route('id'),
            'company_tel' => ['regex:/^(^\+62\s?|^0)(\d{3,4}-?){2}\d{3,4}$/','nullable'],
            'company_email' => 'email|nullable',
            'company_industry' => 'string',
            'company_address' => 'string'
        ];
    }
}
