<?php

namespace App\Exceptions;

use Exception;

class NotAuthorizeSales extends Exception
{
    private $error = "User Not Authorized";

    public function render($request)
    {
        return redirect()->back()->with('failed',$this->error);
    }
}
