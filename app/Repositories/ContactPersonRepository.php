<?php 

namespace App\Repositories;

use App\ContactPerson;

interface ContactPersonRepository
{
    public function create(ContactPerson $company);
    public function remove($id);
    public function update(ContactPerson $company, $id);
    public function all();
    public function find($id);
}