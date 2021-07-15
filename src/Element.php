<?php

namespace Domattr\Exml;

use InvalidArgumentException;

class Element
{
    private ?string $namespace = null;
    private ?string $tag = null;
    private array $attributes = [];
    private array $children = [];
    private string $value = '';

    public function setTag(string $tag): self
    {
        $this->tag = $tag;
        return $this;
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

    public function addAttribute(Attribute $attribute): self
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function addChild(Element $child): Element
    {
        if (is_null($child->tag()) || empty($child->tag())) {
            throw new InvalidArgumentException('Child does not have tag set');
        }

        if (!array_key_exists($child->tag(), $this->children())) {
            $this->children[$child->tag()] = $child;
            return $child;
        }

        if (!is_array($this->children[$child->tag()])) {
            $this->children[$child->tag()] = [$this->children()[$child->tag()]];
        }

        $this->children[$child->tag()][] = $child;

        return $child;
    }

    public function children(): array
    {
        return $this->children;
    }

    public function __get(string $key)
    {
        if (array_key_exists($key, $this->children)) {
            return $this->children[$key];
        }

        return null;
    }

    public function hydrate(ContentDTO $dto): self
    {
        // Process Tag and Namespace
        $details = $this->processTag($dto->tag());
        $this->setTag($details['tag']);
        $this->setNamespace($details['namespace']);

        // Add Attributes
        if (!empty($dto->attributes())) {
            foreach (explode(' ', $dto->attributes()) as $attr) {
                $this->addAttribute(new Attribute($attr));
            }
        }

        return $this;
    }

    protected function processTag(string $rawTag): array
    {
        $element = explode(':', $rawTag);
        if (count($element) > 1) {
            $namespace = $element[0];
            $tag = $element[1];
            return ['tag' => $tag, 'namespace' => $namespace];
        }
        $tag = $element[0];
        $namespace = null;
        return ['tag' => $tag, 'namespace' => $namespace];
    }

    protected function openingTag(): string
    {
        $tag = $this->tag();
        if (!is_null($this->namespace)) {
            $tag = $this->namespace . ':' . $this->tag();
        }

        foreach ($this->attributes() as $attr) {
            $tag .= ' ' . $attr->key() . '="' . $attr->value() . '"';
        }

        return "<$tag>";
    }

    protected function closingTag(): string
    {
        $tag = $this->tag();
        if (!is_null($this->namespace)) {
            $tag = $this->namespace . ':' . $this->tag();
        }

        return "</$tag>";
    }

    protected function parseChildren(): string
    {
        $str = '';

        foreach ($this->children() as $child) {
            if (is_a($child, Element::class)) {
                $str .= $child->openingTag();

                if (strlen($child->value()) > 0) {
                    $str .= $child->value();
                } else {
                    $str .= $child->parseChildren();
                }

                $str .= $child->closingTag();
            } else {
                foreach ($child as $sibling) {
                    $str .= $sibling->openingTag();

                    if (strlen($sibling->value()) > 0) {
                        $str .= $sibling->value();
                    } else {
                        $str .= $sibling->parseChildren();
                    }

                    $str .= $sibling->closingTag();
                }
            }
        }
        return $str;
    }
}
