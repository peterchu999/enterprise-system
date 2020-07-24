<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;


class CreateCompanyRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'company_name' => 'required|string|min:2|unique:companies,company_name',
            'company_prefix' => ['required',Rule::in(['PT.','CV.','TOKO','BPK','IBU'])],
            'company_tel' => 'nullable',
            'company_email' => 'email|nullable',
            'company_industry' => 'exists:industries,id',
            'company_address' => 'string|required',
            'contact_person' => Rule::requiredIf(
                                    $this->company_prefix == "PT." ||
                                    $this->company_prefix == "CV." ||
                                    $this->company_prefix == "TOKO"),
            'contact_person.name' => 'required_with:contact_person',
            'contact_person.phone' => ['regex:/^(^\+62\s?|^0)(\d{3,4}-?){2}\d{3,4}$/','required_with:contact_person'],
            'contact_person.email' => 'email|nullable',
            'contact_person.department' => 'string|nullable',
            'contact_person.position' => 'string|nullable',
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