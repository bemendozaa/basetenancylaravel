<?php

namespace App\Exceptions;

use Exception;

class TestingDatabaseNotFoundException extends Exception
{
    public function __construct($message = "Base de datos de prueba para testing no encontrada", $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
