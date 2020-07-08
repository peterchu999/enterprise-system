<?php

namespace App\Http\Responses\Entity\ContactPerson;

use Illuminate\Contracts\Support\Responsable;

use App\Http\Responses\BaseResponse;

class ContactPersonResponse implements Responsable {
    private $contact_name;

    public function __construct($contact_name)
    {
        $this->contact_name = $contact_name;
    }

    public function toResponse($req = null)
    {
        return response()->json([
            'contact_person_name' => $this->contact_name
        ]);
    }

}