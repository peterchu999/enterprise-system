<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    protected $fillable = ['id', 'company_name','company_address','company_tel','company_email','company_industry','sales_id'];

    public function ContactPerson()
    {
        return $this->hasMany('App\ContactPerson');
    }

    public function Sales() {
        return $this->belongsTo('App\User','sales_id','id');
    }

    public function Offer()
    {
        return $this->hasMany('App\Offer');
    }
}
