<?php 

namespace App\Services;

use Illuminate\Http\Request;

interface ContactPersonService
{
    public function insertContactPerson(Request $request);
    public function updateContactPerson(Request $request,$id);
    public function fetchAllContactPerson();
    public function fetchContactPerson($id);
    public function removeContactPerson($id);
}   