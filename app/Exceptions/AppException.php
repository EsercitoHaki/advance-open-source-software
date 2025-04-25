<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return response()->json([
            'error' => $this->getMessage(),
            'code' => $this->getCode()
        ], 400); 
    }
}
