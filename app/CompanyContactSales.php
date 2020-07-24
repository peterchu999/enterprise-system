<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyContactSales extends Model
{
    protected $fillable = ['id','company_id','sales_id','contact_person_id'];

    public function Sales(){
        return $this->belongsTo('App\User','sales_id','id');
    }

    public function Company(){
        return $this->belongsTo('App\Company','company_id','id');
    }

    public function ContactPerson(){
        return $this->belongsTo('App\ContactPerson','contact_person_id','id');
    }
}
