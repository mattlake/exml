<?php

namespace Domattr\Exml;

class RootElement extends Element
{
    private string $version = '1.0';
    private string $encoding = 'utf-8';

    public function setVersion(string $version): static
    {
        $this->version = $version;
        return $this;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function setEncoding(string $encoding): static
    {
        $this->encoding = $encoding;
        return $this;
    }

    public function encoding(): string
    {
        return $this->encoding;
    }

    public function hydrate(ContentDTO $dto): static
    {
        $this->version = $dto->headers()['version'] ?? '1.0';
        $this->encoding = $dto->headers()['encoding'] ?? 'utf-8';

        parent::hydrate($dto);

        return $this;
    }

    public function toXML(): string
    {
        $str = '<?xml version="' . $this->version() . '" encoding="' . $this->encoding() . '"?>';
        $str .= $this->openingTag();

        if (strlen($this->value() > 0)) {
            $str .= $this->value();
        } else {
            $str .= $this->parseChildren();
        }
        $str .= $this->closingTag();
        return $str;
    }

    public static function create(string $tag, string $version = '1.0', string $encoding = 'utf-8'): RootElement
    {
        return (new RootElement())->setTag($tag)->setVersion($version)->setEncoding($encoding);
    }
}
