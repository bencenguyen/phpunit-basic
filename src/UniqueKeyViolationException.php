<?php

namespace App;

use Exception;

class UniqueKeyViolationException extends Exception
{
    public function __construct($id, Exception $ex)
    {
        parent::__construct("This value already appears in database" . $id, 23000, $ex);
    }
}