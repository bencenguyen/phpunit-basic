<?php

namespace App;

class NoSuchElementException extends \Exception
{
    public function __construct($id)
    {
        parent::__construct("No such element with id: " . $id);
    }
}