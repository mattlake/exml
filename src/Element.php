<?php

namespace Domattr\Exml;

use InvalidArgumentException;

class Element
{
    private ?string $namespace = null;
    private ?string $tag = null;
    private array $attributes = [];
    private array $children = [];
    private mixed $value = null;

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
        $this->attributes[$attribute->key()] = $attribute;
        return $this;
    }

    public function hasAttribute(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

    public function getAttribute(string $key): string
    {
        return $this->attributes[$key];
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

    public function value(): mixed
    {
        return $this->value;
    }

    public function addChild(Element $child): Element
    {
        if (is_null($child->tag()) || empty($child->tag())) {
            throw new InvalidArgumentException('Child does not have tag set');
        }

        if (! array_key_exists($child->tag(), $this->children())) {
            $this->children[$child->tag()] = $child;
            return $child;
        }

        if (! is_array($this->children[$child->tag()])) {
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
        if (! empty($dto->attributes())) {
            foreach (explode(' ', $dto->attributes()) as $attr) {
                $this->addAttribute(new Attribute($attr));
            }
        }

        return $this;
    }

    private function processTag(string $rawTag): array
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
}
