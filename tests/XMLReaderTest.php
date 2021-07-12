<?php

namespace Domattr\XMLReader\Tests;

use Domattr\XMLReader\XMLElement;
use Domattr\XMLReader\XMLReader;

it(
    'returns XML Element for basic $xml',
    function () {
        $xml = '<Name>Matt</Name>';
        $obj = XMLReader::readXML($xml);

        expect($obj)->toBeInstanceOf(XMLElement::class);
        expect($obj->tag())->toBe('Name');
        expect($obj->value())->toBe('Matt');
    }
);

it(
    'returns XML element with 1 child element',
    function () {
        $xml = '<Customer><Name>Matt</Name></Customer>';
        $obj = XMLReader::readXML($xml);

        expect($obj)->toBeInstanceOf(XMLElement::class);
        expect($obj->tag())->toBe('Customer');
        expect($obj->children())->toBeArray();
        expect($obj->Name)->toBeInstanceOf(XMLElement::class);
        expect($obj->Name->tag())->toBe('Name');
        expect($obj->Name->value())->toBe('Matt');
    }
);

it(
    'returns XML element with multiple child element',
    function () {
        $xml = '<Customer><Name>Matt</Name><Age>37</Age></Customer>';
        $obj = XMLReader::readXML($xml);

        expect($obj)->toBeInstanceOf(XMLElement::class);
        expect($obj->tag())->toBe('Customer');
        expect($obj->children())->toBeArray();
        expect($obj->Name)->toBeInstanceOf(XMLElement::class);
        expect($obj->Name->tag())->toBe('Name');
        expect($obj->Name->value())->toBe('Matt');
        expect($obj->Age)->toBeInstanceOf(XMLElement::class);
        expect($obj->Age->tag())->toBe('Age');
        expect($obj->Age->value())->toBe('37');
    }
);

it(
    'returns XML element with 2 tiers of child elements',
    function () {
        $xml = '<Account><Customer><Name>Matt</Name></Customer></Account>';
        $obj = XMLReader::readXML($xml);

        expect($obj)->toBeInstanceOf(XMLElement::class);
        expect($obj->tag())->toBe('Account');
        expect($obj->children())->toBeArray();
        expect($obj->Customer)->toBeInstanceOf(XMLElement::class);
        expect($obj->Customer->tag())->toBe('Customer');
        expect($obj->Customer->Name)->toBeInstanceOf(XMLElement::class);
        expect($obj->Customer->Name->tag())->toBe('Name');
        expect($obj->Customer->Name->value())->toBe('Matt');
    }
);
