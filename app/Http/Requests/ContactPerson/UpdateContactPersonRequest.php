<?php

namespace App\Http\Requests\ContactPerson;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;


class UpdateContactPersonRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'company_id' => 'exists:companies,id',
            'contact_person' => 'array',
            'contact_person.name' => 'string|min:3',
            'contact_person.email' => 'email|unique:contact_people,email,'.$this->route('id'),
            'contact_person.phone' =>  ['regex:/^(^\+62\s?|^0)(\d{3,4}-?){2}\d{3,4}$/','unique:contact_people,email,'.$this->route('id')]
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
