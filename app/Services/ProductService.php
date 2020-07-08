<?php 

namespace App\Services;

use Illuminate\Http\Request;

interface ProductService
{
    public function insertProduct(Request $request);
    public function updateProduct(Request $request,$id);
    public function fetchAllProductWithOffer($offer_id);
    public function fetchProduct($id);
    public function removeProduct($id);
}   