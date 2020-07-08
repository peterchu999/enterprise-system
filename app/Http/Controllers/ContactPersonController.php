<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactPerson\CreateContactPersonRequest;
use App\Http\Requests\ContactPerson\UpdateContactPersonRequest;
use App\Http\Responses\Entity\ContactPerson\ContactPersonCDUResponse;
use App\Http\Responses\Entity\ContactPerson\ContactPersonResponse;
use App\Services\ContactPersonService;
use Symfony\Component\HttpFoundation\Response;

class ContactPersonController extends Controller
{
    protected $service;
    public function __construct(ContactPersonService $service){
        parent::__construct();
        $this->service = $service;
    }

    public function store(CreateContactPersonRequest $req) {
        $this->service->insertContactPerson($req);
        return redirect()->back()->with('success','contact '.$req->contact_person["name"].' berhasil di tambahkan');
    }

    public function update(UpdateContactPersonRequest $req, $id) {
        $cotact_person = $this->service->updateContactPerson($req,$id);
        return redirect()->back()->with('success','contact '.$req->contact_person["name"].' berhasil di update');
    }

    public function index() {
        $contact_person = $this->service->fetchAllContactPerson();
        return $this->responseBuilder
                ->code(Response::HTTP_OK)
                ->data((new ContactPersonResponse($contact_person))->toResponse())
                ->build()
                ->toResponse();
    }

    public function destroy($id) {
        $contact_person = $this->service->removeContactPerson($id);
        return redirect()->back()->with('success','contact '.$req->contact_person["name"].' berhasil di hapu');
    }
    
    public function show($id) {
        $contact_person = $this->service->fetchContactPerson($id);
        return $this->responseBuilder
                ->code(Response::HTTP_OK)
                ->data((new ContactPersonResponse($contact_person))->toResponse())
                ->build()
                ->toResponse();
    }
}
