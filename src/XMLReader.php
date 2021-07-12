<?php

namespace Domattr\XMLReader;

class XMLReader
{
    private static ?XMLReader $instance;

    private function __construct()
    {
    }

    private static function getInstance(): XMLReader
    {
        if (!isset(self::$instance)) {
            self::$instance = new XMLReader();
        }

        return self::$instance;
    }

    public static function readXML($xml): XMLElement
    {
        return self::getInstance()->parseXML($xml);
    }

    private function parseXML(string $xml): XMLElement
    {
        // Create root element
        $rootDTO = ContentDTOFactory::create($xml);
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

    private function createContainer(ContentDTO $dto): XMLElement
    {
        // Create root element
        $el = new XMLContainer();
        $el->hydrate($dto);

        return $el;
    }

    private function createElement(ContentDTO $dto): XMLElement
    {
        // Create root element
        $el = new XMLElement();
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
