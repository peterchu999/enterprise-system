<?php 

namespace App\Repositories;

use App\Offer;

interface OfferRepository
{
    public function create(Offer $offer, $product);
    public function remove($id);
    public function update(Offer $offer, $id);
    public function all($query);
    public function find($id);
}