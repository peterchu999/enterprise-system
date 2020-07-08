<?php 

namespace App\Repositories;

use App\Product;

interface ProductRepository
{
    public function create(Product $product);
    public function createMany($arr_product);
    public function remove($id);
    public function update(Product $product, $id);
    public function all();
    public function find($id);
}