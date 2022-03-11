<?php

declare(strict_types=1);

namespace Domattr\Exml\Exceptions;

use Exception;

class ClassNotFoundException extends Exception
{
    protected $message = 'Specified classname could not be found';
}
