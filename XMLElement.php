<?php

namespace Mattlake;

class XMLElement
{
    private ?string $namespace = null;
    private ?string $tag = null;
    private array $attributes = [];
    private array $children = [];
    private mixed $value = null;

    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    public function tag(): ?string
    {
        return $this->tag;
    }

    public function setNamespace(string|null $namespace): self
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function namespace(): ?string
    {
        return $this->namespace;
    }

    public function addAttribute(XMLAttribute $attribute): self
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function addChild(XMLElement $child)
    {
        $this->children[$child->tag()] = $child;
        return $child;
    }

    public function children(): array
    {
        return $this->children;
    }
}