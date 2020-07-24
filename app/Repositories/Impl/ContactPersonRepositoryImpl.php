<?php 

namespace App\Repositories\Impl;

use Carbon\Carbon;

use App\Repositories\ContactPersonRepository;
use App\ContactPerson;

class ContactPersonRepositoryImpl implements ContactPersonRepository
{
    protected $model;

    public function __construct(ContactPerson $contact_person) {
        $this->model = $contact_person;
    }

    public function create(ContactPerson $contact_person) {
        return $this->model->create($contact_person->getAttributes());
    }

    public function remove($id) {
        $contact_person = $this->model->find($id);
        $contact_person->delete();
        return $contact_person;
    }

    public function update(ContactPerson $contact_person, $id) {
        $cp = $this->model->find($id);
        $cp->update($contact_person->getAttributes());
        return $cp;
    }

    public function all() {
        return $this->model->all();
    }

    public function find($id) {
        return $this->model->with('Company')->where('id',$id)->first();
    }
}