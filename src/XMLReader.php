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

        // Process Tag and Namespace
        $details = $this->processTag($dto->tag());
        $el->setTag($details['tag']);
        $el->setNamespace($details['namespace']);

        // Add Attributes
        if (!empty($dto->attributes())) {
            foreach (explode(' ', $dto->attributes()) as $attr) {
                $el->addAttribute(new XMLAttribute($attr));
            }
        }

        return $el;
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

    private function createElement(ContentDTO $dto): XMLElement
    {
        // Create root element
        $el = new XMLElement();

        // Process Tag and Namespace
        $details = $this->processTag($dto->tag());
        $el->setTag($details['tag']);
        $el->setNamespace($details['namespace']);

        // Add Attributes
        if (!empty($dto->attributes())) {
            foreach (explode(' ', $dto->attributes()) as $attr) {
                $el->addAttribute(new XMLAttribute($attr));
            }
        }

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
