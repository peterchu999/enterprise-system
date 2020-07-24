<?php 

namespace App\Repositories;

use App\Company;

interface CompanyRepository
{
    public function create(Company $company,$contact_person,$sales_id);
    public function remove($id);
    public function update(Company $company, $id);
    public function all($sales_id);
    public function find($id);
}