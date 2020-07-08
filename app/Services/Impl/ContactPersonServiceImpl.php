<?php 
namespace App\Services\Impl;

use Illuminate\Http\Request;
use App\Repositories\ContactPersonRepository;
use App\Services\ContactPersonService;
use App\Http\Responses\Entity\BaseErrorResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\ContactPerson;
use Illuminate\Support\Facades\Auth;


class ContactPersonServiceImpl implements ContactPersonService
{
    protected $repository;

    public function __construct(ContactPersonRepository $repository) {
        $this->repository = $repository;
    }

    public function insertContactPerson(Request $request) {
        $contact_person = $this->buildContactPersonWith($request);
        return $this->repository->create($contact_person);
    }

    public function updateContactPerson(Request $request,$id) {
        $this->validateCredentialAndModelExist($id);
        $contact_person = $this->buildContactPersonWith($request);
        return $this->repository->update($contact_person, $id);
    }

    public function fetchAllContactPerson() {
        return $this->repository->all();
    }

    public function fetchContactPerson($id) {
        $this->validateCredentialAndModelExist($id);
        return $this->repository->find($id);
    }

    public function removeContactPerson($id) {
        $this->validateCredentialAndModelExist($id);
        return $this->repository->remove($id);
    }

    private function buildContactPersonWith(Request $request) {
        return new ContactPerson([
            $request->company_id ? 'company_id' : 'undefined' => $request->company_id,
            $request->contact_person["name"] ? 'name' : 'undefined' =>  strtoupper($request->contact_person["name"]),
            $request->contact_person["phone"] ? 'phone' : 'undefined' => $request->contact_person["phone"],
            $request->contact_person["email"] ? 'email' : 'undefined' => $request->contact_person["email"]
        ]);
    }

    private function validateCredentialAndModelExist($id) {
        if(!ContactPerson::where('id',$id)->exists()){
            throw new ModelNotFound("Contact Person with this id not found");
        } 
        $sales = Auth::user();
        if (ContactPerson::where('id',$id)->first()->sales_id != $sales->id && $sales->role != "admin"){
            $exception = new NotAuthorizeSales("User tidak memiliki akses");
            throw $exception;   
        }
    }
}   