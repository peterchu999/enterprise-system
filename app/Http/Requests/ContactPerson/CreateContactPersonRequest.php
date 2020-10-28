<?php

namespace App\Http\Requests\ContactPerson;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;


class CreateContactPersonRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'contact_person' => 'required|array|min:2',
            'contact_person.name' => 'required|string|min:3',
            'contact_person.phone' =>  ['required','regex:/^(^\+62\s?|^0)(\d{3,4}-?){2}\d{3,4}$/']
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
            'company_address.required'  => 'Alamat Perusahaan harus diisi',
            'company_industry.required'  => 'Kolom industri harus diisi',
        ];
    }
}