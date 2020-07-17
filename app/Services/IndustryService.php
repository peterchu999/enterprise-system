<?php 

namespace App\Services;

use Illuminate\Http\Request;

interface IndustryService
{
    public function insertIndustry(Request $request);
    public function updateIndustry(Request $request,$id);
    public function fetchAllIndustry();
    public function fetchIndustry($id);
    public function removeIndustry($id);
}   