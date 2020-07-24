<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    protected $fillable = ['id', 'company_name','company_address','company_tel','company_email','company_industry'];

    public function ContactPerson()
    {
        return $this->belongsToMany('App\ContactPerson', 'company_contact_sales', 'company_id', 'contact_person_id');
    }

    public function CompanyContactSales()
    {
        return $this->hasMany('App\CompanyContactSales');
    }

    public function Sales()
    {
        return $this->belongsToMany('App\User', 'company_contact_sales', 'company_id', 'sales_id');
    }

    public function Industry() {
        return $this->belongsTo('App\Industry','company_industry','id');
    }

    public function Offer()
    {
        return $this->hasMany('App\Offer');
    }
}
