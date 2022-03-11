<?php

declare(strict_types=1);

namespace Domattr\Exml\Exceptions;

use Exception;

class NoTagSetException extends Exception
{
    protected $message = 'The XML element does not have a tag set';
}
