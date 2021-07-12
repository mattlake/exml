<?php

namespace Domattr\Exml;

class ContentDTO
{
    public function __construct(
        private string $tag,
        private string $attributes = '',
        private string $content = '',
    ) {
    }

    public function tag(): string
    {
        return $this->tag;
    }

    public function attributes(): string
    {
        return $this->attributes;
    }

    public function content(): string
    {
        return $this->content;
    }
}
