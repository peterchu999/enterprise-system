<?php 

namespace App\Repositories\Impl;

use Carbon\Carbon;

use App\Repositories\ProductRepository;
use App\Product;

class ProductRepositoryImpl implements ProductRepository
{
    protected $model;

    public function __construct(Product $product) {
        $this->model = $product;
    }

    public function create(Product $product) {
        $this->model->create($product->getAttributes());
    }

    public function createMany($arr_product) {
        $this->model->insert($arr_product);
    }

    public function remove($id) {
        $offer = $this->model->find($id);
        $offer->delete();
        return $offer;
    }

    public function update(Product $product, $id) {
        $prod = $this->model->find($id);
        $prod->update($product->getAttributes());
        return $prod;
    }

    public function all() {
        return $this->model->all();
    }

    public function find($id) {
        return $this->model->with('Company','Sales','Product')->where('id',$id)->first();
    }
}