<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $fillable = ['id','name'];

    public function Company() {
        return $this->hasMany('App\Industry','company_industry','id');
    }
}
