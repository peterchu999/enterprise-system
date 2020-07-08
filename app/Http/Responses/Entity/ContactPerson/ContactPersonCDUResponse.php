<?php

namespace App\Http\Responses\Entity\ContactPerson;

use Illuminate\Contracts\Support\Responsable;

use App\Http\Responses\BaseResponse;

class ContactPersonCDUResponse implements Responsable {
    private $contact_name;
    private $message;

    public function __construct($contact_name, $message)
    {
        $this->contact_name = $contact_name;
        $this->message = $message;
    }

    public function toResponse($req = null)
    {
        return response()->json([
            'contact_person_name' => $this->contact_name,
            'message' => $this->message,
        ]);
    }

}