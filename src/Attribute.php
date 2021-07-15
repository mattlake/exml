<?php

namespace Domattr\Exml;

class Attribute
{
    private string $key = '';
    private string $value = '';

    public function __construct(string $attr)
    {
        if (!empty($attr)) {
            $entry = explode('=', $attr);
            $this->key = $entry[0];
            $this->value = trim($entry[1], "\"");
        }
    }

    public function key(): string
    {
        return $this->key;
    }

    public function value(): string
    {
        return $this->value;
    }
}
