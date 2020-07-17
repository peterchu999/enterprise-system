<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferCounter extends Model
{
    protected $fillable = ['id','ppn'];

    public function Offer(){
        $this->hasOne('App\Offer');
    }
}
