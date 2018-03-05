<?php

namespace App\Command\Exception;

use RuntimeException;

class NotExistGameException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('This game does not exist, try go to another one or create a new one');
    }
}