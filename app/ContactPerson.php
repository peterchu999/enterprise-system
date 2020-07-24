<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    protected $fillable = ['id','name','phone','email','position','department'];

    public function Company()
    {
        return $this->belongsToMany('App\Company', 'company_contact_sales', 'contact_person_id', 'company_id');
    }

    public function Sales() 
    {
        return $this->belongsToMany('App\User', 'company_contact_sales', 'contact_person_id', 'sales_id');
    }

    public function CompanyContactSales() {
        return $this->hasOne('App\CompanyContactSales');
    }
}