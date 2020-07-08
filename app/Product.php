<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['id','name','qty','price','offer_id'];

    public function Offer(){
        return $this->belongsTo('App\Offer','offer_id');
    }
    
}