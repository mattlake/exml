<?php

namespace Domattr\Exml;

class Container extends Element
{
    private string $version = "1.0";
    private string $encoding = "utf-8";

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

    public function hydrate(ContentDTO $dto): self
    {
        $this->version = $dto->headers()['version'] ?? "1.0";
        $this->encoding = $dto->headers()['encoding'] ?? "utf-8";

        return parent::hydrate($dto);
    }

    public function toXML(): string
    {
        $str = '<?xml version="' . $this->version() . '" encoding="' . $this->encoding() . '"?>';
        $str .= $this->openingTag();
        $str .= $this->closingTag();
        return $str;
    }
}
