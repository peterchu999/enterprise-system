<?php

namespace App\Exceptions;

use Exception;

class OfferNumberException extends Exception
{
    private $error = "No penawaran sudah dipakai";

    public function render($request)
    {
        return redirect()->back()->with('failed',$this->error)->withInput($request->input());
    }
}
