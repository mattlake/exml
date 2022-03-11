<?php

declare(strict_types=1);

namespace Domattr\Exml\Exceptions;

use Exception;

class NoRootElementFoundException extends Exception
{
    protected $message = "A single root element could not be found in the XML";
}
