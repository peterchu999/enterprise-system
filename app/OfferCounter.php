<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferCounter extends Model
{
    protected $fillable = ['id','ppn','offer_number'];

    public function Offer(){
        $this->hasOne('App\Offer');
    }
}
