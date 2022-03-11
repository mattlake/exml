<?php

declare(strict_types=1);

namespace Domattr\Exml;

class Container extends Element
{
    private string $version;
    private string $encoding;

    public function __construct(ContentDTO $dto)
    {
        $this->version = $dto->headers()['version'] ?? "1.0";
        $this->encoding = $dto->headers()['encoding'] ?? "utf-8";
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
