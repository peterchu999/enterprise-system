<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    protected $fillable = ['id','name','phone','email','company_id'];

    public function Company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }
}