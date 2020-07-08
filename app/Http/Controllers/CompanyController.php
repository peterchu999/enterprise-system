<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Responses\Entity\Company\CompanyCDUResponse;
use App\Http\Responses\Entity\Company\CompanyResponse;
use App\Services\CompanyService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class CompanyController extends Controller
{
    protected $service;
    public function __construct(CompanyService $service){
        parent::__construct();
        $this->service = $service;
    }

    public function store(CreateCompanyRequest $req) {
        $this->service->insertCompany($req);
        return redirect()->back()->with('success','company '.$req->company_name.' berhasil di tambahkan');
    }

    public function storeView() {
        $companies = $this->service->fetchAllCompany();
        return view('Offer.add')->with(['companies' => $companies]);
    }

    public function update(UpdateCompanyRequest $req, $id) {
        $company = $this->service->updateCompany($req,$id);
        return redirect()->back()->with('success','company '.$company->company_name.' berhasil di update');
    }

    public function index() {
        $companies = $this->service->fetchAllCompany();
        return view('company.index')->with('companies',$companies);
    }

    public function destroy($id) {
        $company = $this->service->removeCompany($id);
        return redirect()->back()->with('warning','company '.$company->company_name.' berhasil di hapus');
    }
    
    public function show($id) {
        $company = $this->service->fetchCompany($id);
        return view('company.detail')->with('company',$company);
    }

    public function checkCompanyAvail(Request $req) {
        $company = $this->service->checkCompanyWithName($req);
        $url = is_null($company) ? null : URL::signedRoute('Company.link', Crypt::encryptString($company->id));
        return redirect()->back()->with(['check_company'=> $company ?? "NON" ,'req_company_name'=>$req->company_name_check, 'url_link' => $url]);
    }

    public function linkCompany(Request $req, $id) {
        try{
            $id = Crypt::decryptString($id);
        } catch (DecryptException $err) {
            return redirect()->back()->with('failed_link','Error ketika encrypt');
        }
        $company = $this->service->linkCompany($req,$id);
        return redirect()->back()->with('success_link','company '.$company->company_name.' berhasil di tambahkan');
    }
}
