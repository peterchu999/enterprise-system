<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;


class CreateCompanyRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'company_name' => 'required|string|min:5|unique:companies,company_name',
            'company_tel' => ['regex:/^(^\+62\s?|^0)(\d{3,4}-?){2}\d{3,4}$/','nullable'],
            'company_email' => 'email|nullable',
            'company_industry' => 'string',
            'company_address' => 'string|required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'company_name.required' => 'Nama perusahaan harus disertakan',
            'company_tel.required'  => 'Nomor telepon perusahaan harus disertakan',
            'company_email.required'  => 'Email perusahaan harus diisi',
            'company_address.required'  => 'Alamat Perusahaan harus diisi',
            'company_industry.required'  => 'Kolom industri harus diisi',
        ];
    }
}