<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Offer\CreateOfferRequest;
use App\Http\Requests\Offer\UpdateOfferRequest;
use App\Services\OfferService;

class OfferController extends Controller
{
    protected $service;
    public function __construct(OfferService $service){
        parent::__construct();
        $this->service = $service;
    }

    public function store(CreateOfferRequest $req) {
        $this->service->insertOffer($req);
        return redirect()->route('Offer.index')->with('success','Laporan '.$req->company_name.' berhasil di tambahkan');
    }

    public function update(UpdateOfferRequest $req, $id) {
        $offer = $this->service->updateOffer($req,$id);
        return redirect()->route('Offer.show',$id)->with('success','Data laporan berhasil di ubah');
    }

    public function editView($id) {
        $offer = $this->service->fetchOffer($id);
        return view('Offer.edit')->with('offer',$offer);
    }

    public function index(Request $req) {
        $data = $this->service->fetchAllOffer($req);
        return view('Offer.index')->with(['offers'=>$data["offers"],'companies'=>$data["companies"],'sales'=>$data['sales']]);
    }

    public function ppn($id) {
        $this->service->updatePPN($id);
        return redirect()->back();
    }

    public function destroy($id) {
        $offer = $this->service->removeOffer($id);
        return redirect()->route('Offer.index',$id)->with('success','Data laporan berhasil di hapus');
    }
    
    public function show($id) {
        $data = $this->service->fetchOffer($id);
        return view('Offer.detail')->with(['offer'=>$data["offer"],'companies'=>$data["companies"]]);
    }

    public function offerNumber($id, Request $req) {
        $this->service->editOfferNumber($id, $req);
        return redirect()->back()->with('success','No Penawaran berhasil di ganti');
    }
}
