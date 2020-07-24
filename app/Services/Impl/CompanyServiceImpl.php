<?php 
namespace App\Services\Impl;

use Illuminate\Http\Request;
use App\Repositories\CompanyRepository;
use App\Repositories\IndustryRepository;
use App\Services\CompanyService;
use App\Http\Responses\Entity\BaseErrorResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Exceptions\ModelNotFound;
use App\Exceptions\NotAuthorizeSales;
use App\Company;
use Illuminate\Support\Facades\Auth;


class CompanyServiceImpl implements CompanyService
{
    protected $repository,$industryRepository;

    public function __construct(CompanyRepository $repository, IndustryRepository $indRep) {
        $this->repository = $repository;
        $this->industryRepository = $indRep;
    }

    public function insertCompany(Request $request) {
        $company = $this->buildCompanyWith($request);
        return $this->repository->create($company,$request->contact_person,Auth::user()->id);
    }

    public function updateCompany(Request $request,$id) {
        $this->validateCredentialAndModelExist($id);
        $company = $this->buildCompanyWith($request);
        return $this->repository->update($company, $id);
    }

    public function linkCompany(Request $req, $id) {
        return $this->repository->updateSalesId(['sales_id' => Auth::user()->id], $id);
    }

    public function fetchAllCompany() {
        $sales = Auth::user();
        if($sales->role == "admin"){
            return $this->repository->allAdmin();
        }
        return $this->repository->all($sales->id);
    }

    public function fetchAllIndustry() {
        return $this->industryRepository->all();
    }

    public function fetchCompany($id) {
        $this->validateCredentialAndModelExist($id);
        return $this->repository->find($id);
    }

    public function removeCompany($id) {
        $this->validateCredentialAndModelExist($id);
        return $this->repository->remove($id);
    }

    private function checkCompanyAddressPrefix(Request $request) {
        if ($request->company_address) {
            if(substr(strtoupper($request->company_address), 0, 3 ) === "JL.") {
                $request->company_address = "JL. ".ucwords(substr($request->company_address,3));
            } else if (substr(strtoupper($request->company_address), 0, 3 ) === "JLN") {
                $request->company_address = "JL. ".ucwords(substr($request->company_address,3));
            } else if (substr(strtoupper($request->company_address), 0, 4 ) === "JLN."){
                $request->company_address = "JL. ".ucwords(substr($request->company_address,4));
            } else if (substr(strtoupper($request->company_address), 0, 5 ) === "JALAN") {
                $request->company_address = "JL. ".ucwords(substr($request->company_address,5));
            } else if (substr(strtoupper($request->company_address), 0, 2 ) === "JL") {
                $request->company_address = "JL. ".ucwords(substr($request->company_address,2));
            } else {
                $request->company_address = "JL. ".ucwords($request->company_address);
            }
        }
    }

    private function checkCompanyNamePrefix(Request $request) {
        if($request->company_prefix) {
            // if(substr(strtoupper($request->company_name), 0, 4 ) === "TOKO"){
            //     $request->company_name = substr($request->company_name,4);
            // } else if (substr(strtoupper($request->company_name), 0, 2 ) === "CV"){
            //     $request->company_name = substr($request->company_name,2);
            // } else if (substr(strtoupper($request->company_name), 0, 3 ) === "C.V"){
            //     $request->company_name = substr($request->company_name,3);
            // } else if (substr(strtoupper($request->company_name), 0, 4 ) === "C.V."){
            //     $request->company_name = substr($request->company_name,4);
            // } else if (substr(strtoupper($request->company_name), 0, 3 ) === "CV."){
            //     $request->company_name = substr($request->company_name,3);
            // } else if (substr(strtoupper($request->company_name), 0, 3 ) === "PT."){
            //     $request->company_name = substr($request->company_name,3);
            // } else if (substr(strtoupper($request->company_name), 0, 4 ) === "P.T."){
            //     $request->company_name = substr($request->company_name,4);
            // } else if (substr(strtoupper($request->company_name), 0, 3 ) === "P.T"){
            //     $request->company_name = substr($request->company_name,3);
            // } else if (substr(strtoupper($request->company_name), 0, 2 ) === "PT"){
            //     $request->company_name = substr($request->company_name,2);
            // } else if (substr(strtoupper($request->company_name), 0, 5 ) === "BAPAK"){
            //     $request->company_name = substr($request->company_name,5);
            // } else if (substr(strtoupper($request->company_name), 0, 5 ) === "BPK"){
            //     $request->company_name = substr($request->company_name,5);
            // } else if (substr(strtoupper($request->company_name), 0, 4 ) === "IBUH"){
            //     $request->company_name = substr($request->company_name,4);
            // } else if (substr(strtoupper($request->company_name), 0, 4 ) === "IBUK"){
            //     $request->company_name = substr($request->company_name,4);
            // } else if (substr(strtoupper($request->company_name), 0, 3 ) === "IBU"){
            //     $request->company_name = substr($request->company_name,3);
            // }
            $request->company_name = $request->company_prefix." ".$request->company_name;
        }
    }

    private function buildCompanyWith(Request $request) {
        $this->checkCompanyAddressPrefix($request);
        $this->checkCompanyNamePrefix($request);
        return new Company([
            $request->company_address ? 'company_address' : 'not_defined' => $request->company_address,
            $request->company_tel ? 'company_tel' : 'not_defined' => $request->company_tel,
            $request->company_email ? 'company_email' : 'not_defined' => $request->company_email,
            $request->company_industry ? 'company_industry' : 'not_defined' => $request->company_industry,
            $request->company_name ? 'company_name' : 'not_defined' => strtoupper($request->company_name),
            'sales_id' => Auth::user()->id
        ]);
    }

    public function checkCompanyWithName(Request $req) {
        return $this->repository->findByName(strtoupper($req->company_prefix." ".$req->company_name_check));
    }

    private function validateCredentialAndModelExist($id) {
        if(!Company::where('id',$id)->exists()){
            throw new ModelNotFound("Company with this id not found");
        } 
        $sales = Auth::user();
        $authorize = false;
        $cmpyLinks = Company::where('id',$id)->first()->CompanyContactSales()->get();
        if ($sales->role != "admin"){
            foreach($cmpyLinks as $link){
                if($link->sales_id == $sales->id){
                    $authorize = true;
                    break;
                }
            }
            if(!$authorize){
                $exception = new NotAuthorizeSales("User tidak memiliki akses");
                throw $exception;
            }
        }
    }
}   