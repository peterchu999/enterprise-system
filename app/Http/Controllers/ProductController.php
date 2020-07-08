<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected $service;
    public function __construct(ProductService $service){
        parent::__construct();
        $this->service = $service;
    }

    public function store(CreateProductRequest $req) {
        $this->service->insertProduct($req);
        return redirect()->back()->with('success','produk '.$req->name.' berhasil di tambahkan');
    }

    public function update(UpdateProductRequest $req, $id) {
        $company = $this->service->updateProduct($req,$id);
        return redirect()->back()->with('success','produk '.$req->name.' berhasil di update');
    }

    public function destroy($id) {
        $company = $this->service->removeProduct($id);
        return redirect()->back()->with('warning','company '.$company->company_name.' berhasil di hapus');
    }
}
