<?php

namespace Mattlake;

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

    private function parseXML(string $xml)
    {
        // Create root element
        $rootDTO = ContentDTOFactory::create($xml);
        $rootElement = $this->createRootElement($rootDTO);

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

        // count($matches[0])
        // 0 -> The string contains no valid syntax, potentially end of tree
        // 1 -> This is a lone child
        // 2+ -> This has siblings

        // The provided string cannot be parsed down further, return given string
//        if (count($matches[0]) == 0) {
//            return $xml;
//        }

        // For each match we need to parse and attach to parent, WHAT IS THE PARENT????
//        for ($i = 0; $i < count($matches[0]); $i++) {
//            if ($matches['tag'][$i]) {
//                echo "processing match $i" . PHP_EOL;
//                $element = explode(':', $matches['tag'][$i]);
//                if (count($element) > 1) {
//                    $namespace = $element[0];
//                    $tag = $element[1];
//                } else {
//                    $tag = $element[0];
//                }
//
//                $el = new XMLElement($tag);
//
//                if (isset($namespace)) {
//                    $el->addNamespace($namespace);
//                }
//
//                if (!empty($matches['attributes'][$i])) {
//                    foreach (explode(' ', $matches['attributes'][$i]) as $attr) {
//                        $el->addAttribute(new XMLAttribute($attr));
//                    }
//                }
//
//                if (!empty($matches['contents'][$i])) {
//                    $child = self::read($matches['contents'][$i]);
//                    if (is_a($child, XMLElement::class)) {
//                        $el->addChild($child);
//                    } else {
//                        $el->setValue($matches['contents'][$i]);
//                    }
//                }
//
//                return $el;
//            }
//        }
        return $rootElement;
    }

    private function createRootElement(ContentDTO $dto): XMLElement
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