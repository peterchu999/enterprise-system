<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Responses\Builder\BaseResponseBuilder;

class Controller extends BaseController
{
    protected $responseBuilder;

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct() {
        $this->responseBuilder = new BaseResponseBuilder();
    }
}
