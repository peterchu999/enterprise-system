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
use Illuminate\Support\Facades\Auth;

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
        $industries = $this->service->fetchAllIndustry();
        return view('company.index')->with(['companies' => $companies, 'industries' => $industries]);
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
        
        if ($company == null) {
            return redirect()->back()->with(['check_status'=>'NO_COMPANY', 'req_company_name'=>strtoupper($req->company_name_check),'req_company_prefix'=>$req->company_prefix]);
        }

        if($company->CompanyContactSales()->count() < 1) {
            $url = is_null($company) ? null : URL::signedRoute('Company.link', Crypt::encryptString($company->id));
            return redirect()->back()->with(['check_status'=>'NO_LINKED_SALES','check_company'=> $company ?? "NON" ,'req_company_name'=>strtoupper($req->company_name_check), 'url_link' => $url,'req_company_prefix'=>$req->company_prefix]);
        }

        $authorized = false;
        foreach($company->CompanyContactSales()->get() as $link){
            if($link->sales_id == Auth::user()->id){
                $authorized = true;
                break;
            }
        }
        if ($authorized) {
            return redirect()->back()->with(['check_status'=>'SALES_COMPANY','check_company'=> $company,'req_company_name'=>strtoupper($req->company_name_check),'req_company_prefix'=>$req->company_prefix]);
        }
        if ($req->company_prefix == "IBU" || $req->company_prefix == "BPK"){
            return redirect()->back()->with(['check_status'=>'CANNOT_LINK_COMPANY','check_company'=> $company,'req_company_name'=>strtoupper($req->company_name_check),'req_company_prefix'=>$req->company_prefix]);
        }
        return redirect()->back()->with(['check_status'=>'MAKE_WITH_CONTACT','check_company'=> $company,'req_company_name'=>strtoupper($req->company_name_check),'req_company_prefix'=>$req->company_prefix]);
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
