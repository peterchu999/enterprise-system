<?php 
namespace App\Services\Impl;

use Illuminate\Http\Request;
use App\Repositories\IndustryRepository;
use App\Services\IndustryService;
use App\Industry;
use Illuminate\Support\Facades\Auth;

class IndustryServiceImpl implements IndustryService
{
    protected $repository;

    public function __construct(IndustryRepository $repository) {
        $this->repository = $repository;
    }

    public function insertIndustry(Request $request){
        $industry = $this->buildIndustryModel($request);
        $this->repository->create($industry);
    }

    public function updateIndustry(Request $request,$id){
        $this->validateModelExist($id);
        $industry = $this->buildIndustryModel($request);
        return $this->repository->update($industry,$id);
    }

    public function fetchAllIndustry(){
        return $this->repository->all();
    }

    public function fetchIndustry($id){
        $this->validateModelExist($id);
        return $this->repository->find($id);
    }

    public function removeIndustry($id){
        $this->validateModelExist($id);
        return $this->repository->remove($id);
    }


    private function validateModelExist($id) {
        if(!Industry::where('id',$id)->exists()){
            throw new ModelNotFound("Company with this id not found");
        }
    }

    private function buildIndustryModel($request) {
        return new Industry([
            $request->industry_name ? 'name' : 'not_defined' => strtoupper($request->industry_name)
        ]);
    }
}   