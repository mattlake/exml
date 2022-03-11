<?php

namespace Domattr\Exml\Exceptions;

class ClassNotFoundException extends \Exception
{
    protected $message = 'Specified classname could not be found';
}