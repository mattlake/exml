<?php

namespace Domattr\XMLReader;


class XMLAttribute
{
    private string $key;
    private string $value;

    public function __construct(string $attr)
    {
        $entry = explode("=", $attr);
        $this->key = $entry[0];
        $this->value = trim($entry[1], "\"");
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
