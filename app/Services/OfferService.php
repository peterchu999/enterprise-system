<?php 

namespace App\Services;

use Illuminate\Http\Request;

interface OfferService
{
    public function insertOffer(Request $request);
    public function updateOffer(Request $request,$id);
    public function fetchAllOffer($req);
    public function fetchOffer($id);
    public function removeOffer($id);
}   