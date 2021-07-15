<?php

namespace Domattr\Exml;

use InvalidArgumentException;

class Exml
{
    private static ?Exml $instance;

    private function __construct()
    {
    }

    private static function getInstance(): Exml
    {
        if (!isset(self::$instance)) {
            self::$instance = new Exml();
        }

        return self::$instance;
    }

    public static function read(string $xml): Element
    {
        return self::getInstance()->parseXML($xml);
    }

    private function parseXML(string $xml): Element
    {
        // Create root element
        $rootDTO = ContentDTOFactory::create($xml);

        if (!is_a($rootDTO, ContentDTO::class)) {
            throw new InvalidArgumentException('No single root element found');
        }

        $rootElement = $this->createContainer($rootDTO);

        return $this->createContent($rootDTO, $rootElement);
    }

    private function createContainer(ContentDTO $dto): Element
    {
        // Create root element
        $el = new RootElement();
        $el->hydrate($dto);

        return $el;
    }

    private function createElement(ContentDTO $dto): Element
    {
        $el = new Element();
        $el->hydrate($dto);

        return $this->createContent($dto, $el);
    }

    private function createContent(ContentDTO|array|string $contentDto, Element $element): Element
    {
        $content = ContentDTOFactory::create($contentDto->content());

        if (is_a($content, ContentDTO::class)) {
            $content = [$content];
        }

        if (!is_array($content)) {
            $element->setValue($content);
        } else {
            foreach ($content as $dto) {
                $element->addChildren([$this->createElement($dto)]);
            }
        }

        return $element;
    }
}
