<?php

namespace App\Http\Responses\Entity\Company;

use Illuminate\Contracts\Support\Responsable;

use App\Http\Responses\BaseResponse;

class CompanyResponse implements Responsable {
    private $company;

    public function __construct($company)
    {
        $this->company = $company;
    }

    public function toResponse($req = null)
    {
        return response()->json([
            'company' => $this->company
        ]);
    }

}