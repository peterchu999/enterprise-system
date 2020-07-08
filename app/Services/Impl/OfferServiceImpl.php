<?php 
namespace App\Services\Impl;

use Illuminate\Http\Request;
use App\Repositories\OfferRepository;
use App\Repositories\CompanyRepository;
use App\Services\OfferService;
use App\Http\Responses\Entity\BaseErrorResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Exceptions\NotAuthorizeSales;
use App\Exceptions\ModelNotFound;
use App\Offer;
use App\User;
use App\OfferCounter;
use Illuminate\Support\Facades\Auth;


class OfferServiceImpl implements OfferService
{
    protected $repository;
    protected $company_repository;

    public function __construct(OfferRepository $repository, CompanyRepository $companyRepo) {
        $this->repository = $repository;
        $this->company_repository = $companyRepo;
    }

    public function insertOffer(Request $request) {
        $products = $request->product ?? [];
        if (count($products) > 0) {
            $offer_number = OfferCounter::create(['name'=> Auth::user()->name]);
        }
        $offer = $this->buildOfferWith($request, $offer_number->id ?? null);
        return $this->repository->create($offer, $products);
    }

    public function updateOffer(Request $request,$id) {
        $sales_id = Auth::user()->id;
        $this->validateCredentialAndModelExist($id);
        $offer = $this->buildOfferWith($request);
        return $this->repository->update($offer, $id);
    }

    public function fetchAllOffer($req) {
        $query = $req->all();
        $sales = Auth::user();
        if ($sales->role == "admin") {
            $data["companies"] = $this->company_repository->allAdmin();
            $data["offers"] = $this->repository->all($query);
            $data["sales"] = User::all(); 
            return $data;
        } 
        $query["sales"] = Auth::user()->id;
        $data["offers"] = $this->repository->all($query);
        $data["companies"] = $this->company_repository->all($sales->id);
        $data["sales"] = null;
        return $data;
    }

    public function fetchOffer($id) {
        $this->validateCredentialAndModelExist($id);
        $sales = Auth::user();
        if ($sales->role == "admin") {
            $data["companies"] = $this->company_repository->allAdmin();
        } else {
            $data["companies"] = $this->company_repository->all($sales->id);
        }
        $data["offer"] = $this->repository->find($id);
        return $data;
    }

    public function removeOffer($id) {
        $this->validateCredentialAndModelExist($id);
        return $this->repository->remove($id);
    }

    private function buildOfferWith(Request $request, $offer_number = null) {
        return new Offer([
            $request->offer_number ? 'offer_number' : 'undefined' => $request->offer_number,
            $request->status ? 'status' : 'undefined' => $request->status,
            $request->information ? 'information' : 'undefined' => $request->information,
            'sales_id' => Auth::user()->id,
            $request->company_id ? 'company_id' : 'undefined' => $request->company_id,
            $request->offer_date ? 'offer_date' : 'undefined' => $request->offer_date,
            $request->purchase_order ? 'purchase_order' : 'undefined' => $request->purchase_order,
            $offer_number ? 'offer_number' : 'undefined' => $offer_number
        ]);
    }

    private function validateCredentialAndModelExist($id) {
        if(!Offer::where('id',$id)->exists()){
            throw new ModelNotFound("Offer with this id not found");
        } 
        if (Offer::where('id',$id)->first()->sales_id != Auth::user()->id && Auth::user()->role != "admin"){
            $exception = new NotAuthorizeSales("User tidak memiliki akses");
            throw $exception;   
        }
    }
}   