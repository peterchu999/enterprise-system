<?php 
namespace App\Services\Impl;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Http\Responses\Entity\BaseErrorResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Product;
use App\Offer;
use App\OfferCounter;
use Illuminate\Support\Facades\Auth;


class ProductServiceImpl implements ProductService
{
    protected $repository;

    public function __construct(ProductRepository $repository) {
        $this->repository = $repository;
    }

    public function insertProduct(Request $request) {
        $product = $this->buildProductWith($request);
        $offer = Offer::where('id',$request->offer_id)->first();
        if($offer->offer_number == null) {
            $offer_number = OfferCounter::create(['ppn'=>true]);
            $offer->offer_number = $offer_number->id;
            $offer->status = 2;
            $offer->save();
        }
        return $this->repository->createMany($product);
    }

    public function updateProduct(Request $request,$id) {
        $this->validateIfProductExist($id);
        $product = $this->buildProductWith($request);
        return $this->repository->update($product, $id);
    }

    public function fetchAllProductWithOffer($offer_id) {
        return $this->repository->all();
    }

    public function fetchProduct($id) {
        $this->validateIfProductExist($id);
        return $this->repository->find($id);
    }

    public function removeProduct($id) {
        $this->validateIfProductExist($id);
        return $this->repository->remove($id);
    }

    private function buildProductWith(Request $request) {
        if ($request->product != null){
            $product = $request->product;
            for($i = 0; $i < count($product);$i++) {
                $product[$i]["offer_id"] = $request->offer_id;
            }
            return $product;
        }
        return new Product([
            $request->name ? 'name' : 'undefined' => $request->name ,
            $request->qty ? 'qty' : 'undefined' => $request->qty ,
            $request->price ? 'price' : 'undefined' => $request->price ,
            $request->offer_id ? 'offer_id' : 'undefined' => $request->offer_id
        ]);
    }

    private function validateIfProductExist($id) {
        if(!Product::where('id',$id)->exists()){
            throw new HttpResponseException(
                ( new BaseErrorResponse( 400, 
                    'Contact person with this id:'.$id.' was not exist')
                )->toResponse());
        }
    }
}   