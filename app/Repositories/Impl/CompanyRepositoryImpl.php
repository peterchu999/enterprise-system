<?php 

namespace App\Repositories\Impl;

use Carbon\Carbon;

use App\Repositories\CompanyRepository;
use App\Company;

class CompanyRepositoryImpl implements CompanyRepository
{
    protected $model;

    public function __construct(Company $company) {
        $this->model = $company;
    }

    public function create(Company $company) {
        $this->model->create($company->getAttributes());
    }

    public function remove($id) {
        $company = $this->model->find($id);
        $company->delete();
        return $company;
    }

    public function update(Company $company, $id) {
        $cmpy = $this->model->find($id);
        $cmpy->update($company->getAttributes());
        return $cmpy;
    }

    public function updateSalesId($sales_query, $id) {
        $cmpy = $this->model->find($id);
        $cmpy->update($sales_query);
        return $cmpy;
    }

    public function all($sales_id) {
        return $this->model->with('Industry')->where('sales_id',$sales_id)->get()->sortByDesc('created_at')->values();
    }

    public function findByName($name) {
        return $this->model->where('company_name',$name)->first();
    }

    public function allAdmin() {
        return $this->model->with('Industry')->get()->sortByDesc('created_at')->values();
    }

    public function find($id) {
        return $this->model->with('ContactPerson')->where('id',$id)->first();
    }
}