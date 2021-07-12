<?php

namespace Domattr\Exml;

class Container extends Element
{
    private string $version;
    private string $encoding;

    public function __construct(string $version = "1.0", string $encoding = "utf-8")
    {
        $this->setVersion($version)->setEncoding($encoding);
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function setEncoding(string $encoding): self
    {
        $this->encoding = $encoding;
        return $this;
    }

    public function encoding(): string
    {
        return $this->encoding;
    }
}