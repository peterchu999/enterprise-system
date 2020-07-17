<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IndustryService;

class IndustryController extends Controller
{
    protected $service;
    public function __construct(IndustryService $service){
        parent::__construct();
        $this->service = $service;
    }

    public function index() {
        $industries = $this->service->fetchAllIndustry();
        return view('industry.index')->with(['industries'=>$industries]);
    }

    public function store(Request $req) {
        $this->service->insertIndustry($req);
        return redirect()->back()->with('success','Industry '.$req->industry_name.' berhasil di tambahkan');
    }

    public function update(Request $req, $id) {
        $industry = $this->service->updateIndustry($req,$id);
        return redirect()->back()->with('success','Industry '.$industry->name.' berhasil di update');
    }

    public function destroy($id) {
        $industry = $this->service->removeIndustry($id);
        return redirect()->back()->with('warning','Industry '.$industry->name.' berhasil di hapus');
    }
}
