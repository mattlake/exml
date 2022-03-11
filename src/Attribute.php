<?php

declare(strict_types=1);

namespace Domattr\Exml;

class Attribute
{
    private string $key;
    private string $value;

    public function __construct(string $attr)
    {
        if (strlen($attr) > 0) {
            $this->initialise($attr);
        }
    }

    private function initialise(string $attr): void
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
