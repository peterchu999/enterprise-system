<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['id','status','sales_id','information','company_id','offer_date','purchase_order','offer_number'];

    public function Company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    public function Sales()
    {
        return $this->belongsTo('App\User', 'sales_id', 'id');
    }

    public function OfferNumber(){
        return $this->belongsTo('App\OfferCounter','offer_number','id');
    }

    public function Product()
    {
        return $this->hasMany('App\Product');
    }

    public function StartDateFilter($date, $query_builder)
    {
        return $date == null ? $query_builder : $query_builder->where('offer_date','>=',$date);
    }

    public function EndDateFilter($date, $query_builder)
    {
        return $date == null ? $query_builder : $query_builder->where('offer_date','<=',$date);
    }

    public function StatusFilter($status, $query_builder)
    {
        if ($status == null){
            return $query_builder;
        } else if ($status == 4) {
            return $query_builder->withCount('Product')->having('product_count','<',1);
        }
        return $query_builder->where('status',$status, $query_builder);
    }

    public function CompanyFilter($id, $query_builder)
    {
        return $id == null ? $query_builder : $query_builder->where('company_id',$id);
    }

    public function SalesFilter($id, $query_builder)
    {
        return $id == null ? $query_builder : $query_builder->where('sales_id',$id);
    }
}
