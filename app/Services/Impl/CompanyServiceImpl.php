<?php 
namespace App\Services\Impl;

use Illuminate\Http\Request;
use App\Repositories\CompanyRepository;
use App\Services\CompanyService;
use App\Http\Responses\Entity\BaseErrorResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Exceptions\ModelNotFound;
use App\Exceptions\NotAuthorizeSales;
use App\Company;
use Illuminate\Support\Facades\Auth;


class CompanyServiceImpl implements CompanyService
{
    protected $repository;

    public function __construct(CompanyRepository $repository) {
        $this->repository = $repository;
    }

    public function insertCompany(Request $request) {
        $company = $this->buildCompanyWith($request);
        return $this->repository->create($company);
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

    public function fetchCompany($id) {
        $this->validateCredentialAndModelExist($id);
        return $this->repository->find($id);
    }

    public function removeCompany($id) {
        $this->validateCredentialAndModelExist($id);
        return $this->repository->remove($id);
    }

    private function buildCompanyWith(Request $request) {
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
        return $this->repository->findByName(strtoupper($req->company_name_check));
    }

    private function validateCredentialAndModelExist($id) {
        if(!Company::where('id',$id)->exists()){
            throw new ModelNotFound("Company with this id not found");
        } 
        $sales = Auth::user();
        if (Company::where('id',$id)->first()->sales_id != $sales->id && $sales->role != "admin"){
            $exception = new NotAuthorizeSales("User tidak memiliki akses");
            throw $exception;   
        }
    }
}   