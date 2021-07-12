<?php

namespace Domattr\Exml;

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

        if(!is_a($rootDTO,ContentDTO::class)) {
            throw new \InvalidArgumentException("No single root element found");
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

        return $rootElement;
    }

    private function createContainer(ContentDTO $dto): Element
    {
        // Create root element
        $el = new Container();
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
