<?php

namespace Mattlake;

class ContentDTO
{
    public function __construct(
        private string $tag,
        private ?string $attributes = null,
        private ?string $content = null,
    ) {}

    public function tag(): string
    {
        return $this->tag;
    }

    public function attributes(): string|null
    {
        return $this->attributes;
    }

    public function content(): string|null
    {
        return $this->content;
    }
}