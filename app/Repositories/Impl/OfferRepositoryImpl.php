<?php 

namespace App\Repositories\Impl;

use Carbon\Carbon;

use App\Repositories\OfferRepository;
use App\Offer;

class OfferRepositoryImpl implements OfferRepository
{
    protected $model;

    public function __construct(Offer $offer) {
        $this->model = $offer;
    }

    public function create(Offer $offer, $product) {
        $this->model->create($offer->getAttributes())->Product()->createMany($product);
    }

    public function remove($id) {
        $offer = $this->model->find($id);
        $offer->delete();
        return $offer;
    }

    public function update(Offer $offer, $id) {
        $of = $this->model->find($id);
        $of->update($offer->getAttributes());
        return $of;
    }

    public function all($query){
        $query_builder = $this->model->with('Sales','Company');
        $this->model->SalesFilter($query['sales'] ?? null, $query_builder);
        $this->model->StartDateFilter($query["start"] ?? null, $query_builder);
        $this->model->EndDateFilter($query["end"] ?? null, $query_builder);
        $this->model->StatusFilter($query["status"] ?? null, $query_builder);
        $this->model->CompanyFilter($query["company_id"] ?? null, $query_builder);
        return $query_builder->orderBy('offer_date', 'desc')->orderBy('created_at', 'desc')->paginate(15);   
    }

    public function find($id) {
        return $this->model->with('Company','Sales','Product')->where('id',$id)->first();
    }
}