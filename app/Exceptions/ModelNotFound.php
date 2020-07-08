<?php

namespace App\Exceptions;

use Exception;

class ModelNotFound extends Exception
{
    private $error = "Item Not Found";

    public function render($request)
    {
        return redirect()->back()->with('failed',$this->error);
    }
}
