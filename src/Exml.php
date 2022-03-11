<?php

namespace Domattr\Exml;

use Domattr\Exml\Exceptions\ClassNotFoundException;
use InvalidArgumentException;

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

    public function asElement():Element {
        return $this->parsed;
    }

    public function into(string $class):object
    {
        if(!class_exists($class)) {
            throw new ClassNotFoundException();
        }

        $deserialisedClass = new $class();

        foreach($this->parsed->children() as $k => $v) {

            if(property_exists($deserialisedClass, $k)) {
                $deserialisedClass->$k = $v->value();
            }

        }
        return $deserialisedClass;
    }

    private function parseXML(string $xml): void
    {
        // Create root element
        $rootDTO = ContentDTOFactory::create($xml);

        if(!is_a($rootDTO,ContentDTO::class)) {
            throw new InvalidArgumentException("No single root element found");
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
