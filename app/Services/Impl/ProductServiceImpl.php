<?php 
namespace App\Services\Impl;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Exceptions\OfferNumberException;
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
            if(OfferCounter::where('offer_number',$request->no_penawaran)->count() > 0){
                throw new OfferNumberException("No Penawaran sudah ada");
            }
            $offer_number = OfferCounter::create(['ppn'=>true, 'offer_number' => $request->no_penawaran]);
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
        $this->validateStatus($id);
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
            throw new ModelNotFound("Offer with this id not found");
        } 
        // if (Product::where('id',$id)->first()->sales_id != Auth::user()->id && Auth::user()->role != "admin"){
        //     $exception = new NotAuthorizeSales("User tidak memiliki akses");
        //     throw $exception;   
        // }
    }

    private function validateStatus($id) {
        $product = Product::where('id',$id)->first();
        $productCounter = Product::where('offer_id',$product->offer_id)->count();
        if($productCounter < 2) {
            $product->Offer->status = null;
            $product->Offer->save();
        }
    }
}   