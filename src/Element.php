<?php

namespace Domattr\Exml;

class Element
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

    public function addAttribute(Attribute $attribute): self
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

    public function addChild(Element $child): Element
    {
        $this->children[$child->tag()] = $child;
        return $child;
    }

    public function children(): array
    {
        return $this->children;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->children)) {
            return $this->children[$key];
        }

        return null;
    }

    public function hydrate(ContentDTO $dto):self
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
