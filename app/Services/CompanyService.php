<?php 

namespace App\Services;

use Illuminate\Http\Request;

interface CompanyService
{
    public function insertCompany(Request $request);
    public function updateCompany(Request $request,$id);
    public function fetchAllCompany();
    public function fetchCompany($id);
    public function removeCompany($id);
}   