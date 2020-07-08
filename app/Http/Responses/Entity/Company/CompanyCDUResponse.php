<?php

namespace App\Http\Responses\Entity\Company;

use Illuminate\Contracts\Support\Responsable;

use App\Http\Responses\BaseResponse;

class CompanyCDUResponse implements Responsable {
    private $company_name;
    private $message;

    public function __construct($company_name, $message)
    {
        $this->company_name = $company_name;
        $this->message = $message;
    }

    public function toResponse($req = null)
    {
        return response()->json([
            'company_name' => $this->company_name,
            'message' => $this->message,
        ]);
    }

}