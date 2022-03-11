<?php

declare(strict_types=1);

namespace Domattr\Exml;

use Domattr\Exml\Exceptions\ClassNotFoundException;
use Domattr\Exml\Exceptions\NoRootElementFoundException;
use ReflectionClass;
use ReflectionException;

class Exml
{
    private ?Element $parsed;

    private function __construct(public string $xml)
    {
    }

    public static function read(string $xml): Exml
    {
        $instance = new Exml($xml);
        $instance->parseXML($xml);
        return $instance;
    }

    public function asElement(): Element
    {
        return $this->parsed;
    }

    public function into(string $class): object
    {
        try {
            $reflectedClass = new ReflectionClass($class);
        } catch (ReflectionException) {
            throw new ClassNotFoundException();
        }

        $classProperties = [];
        foreach ($reflectedClass->getProperties() as $prop) {
            $classProperties[$prop->getName()] = $prop;
        }

        $modelProps = [];

        foreach ($this->parsed->children() as $k => $v) {
            if (array_key_exists($k, $classProperties)) {
                if (!in_array($classProperties[$k]->getType()->getName(), ['boolean', 'integer', 'float', 'string'])) {
                    $modelProps[$k] = $this->deserialise($classProperties[$k]->getType()->getName(), $v->children());
                } else {
                    $modelProps[$k] = $v->value();
                }
            }
        }

        $newClass = new $class();
        foreach ($modelProps as $prop => $data) {
            $newClass->$prop = $data;
        }
        return $newClass;
    }

    private function deserialise(string $className, array $children):Object {
        try {
            $reflectedClass = new ReflectionClass($className);
        } catch (ReflectionException) {
            throw new ClassNotFoundException();
        }

        $classProperties = [];
        foreach ($reflectedClass->getProperties() as $prop) {
            $classProperties[$prop->getName()] = $prop;
        }

        $modelProps = [];
        foreach ($children as $k => $v) {
            if (array_key_exists($k, $classProperties)) {
                if (!in_array($classProperties[$k]->getType()->getName(), ['boolean', 'integer', 'float', 'string'])) {
                    $modelProps[$k] = $this->deserialise($classProperties[$k]->getType()->getName(), $v->children());
                } else {
                    $modelProps[$k] = $v->value();
                }
            }
        }

        $newClass = new $className();
        foreach ($modelProps as $prop => $data) {
            $newClass->$prop = $data;
        }
        return $newClass;
    }

    private function parseXML(string $xml): void
    {
        // Create root element
        $rootDTO = ContentDTOFactory::create($xml);

        if (!is_a($rootDTO, ContentDTO::class)) {
            throw new NoRootElementFoundException();
        }

        $rootElement = $this->createContainer($rootDTO);

        $content = ContentDTOFactory::create($rootDTO->content());

        if (is_a($content, ContentDTO::class)) {
            $content = [$content];
        }

        if (!is_array($content)) {
            $rootElement->setValue($content);
        } else {
            foreach ($content as $dto) {
                $rootElement->addChild($this->createElement($dto));
            }
        }

        $this->parsed = $rootElement;
    }

    private function createContainer(ContentDTO $dto): Element
    {
        // Create root element
        $el = new Container($dto);
        $el->hydrate($dto);

        return $el;
    }

    private function createElement(ContentDTO $dto): Element
    {
        $el = new Element();
        $el->hydrate($dto);

        $content = ContentDTOFactory::create($dto->content());

        if (is_a($content, ContentDTO::class)) {
            $content = [$content];
        }

        if (!is_array($content)) {
            $el->setValue($content);
        } else {
            foreach ($content as $dto) {
                $el->addChild($this->createElement($dto));
            }
        }

        return $el;
    }
}
