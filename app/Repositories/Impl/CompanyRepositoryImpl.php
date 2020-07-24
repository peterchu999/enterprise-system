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

    public function create(Company $company,$contact_person,$sales_id) {
        $company = $this->model->create($company->getAttributes())->CompanyContactSales()->create([
            'sales_id' => $sales_id
        ]);
        $cp_id = $contact_person ? $company->ContactPerson()->create($contact_person)->id : null;
        $company->contact_person_id = $cp_id;
        $company->save();
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
        return $this->model->whereHas('CompanyContactSales', function ($query) use($sales_id){
            $query->where('sales_id', $sales_id);
        })->with(['Industry','Sales'])->get()->sortByDesc('created_at')->values();
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