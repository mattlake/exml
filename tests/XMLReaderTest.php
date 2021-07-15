<?php

namespace Domattr\Exml\Tests;

use Domattr\Exml\Container;
use Domattr\Exml\Element;
use Domattr\Exml\Exml;

it(
    'returns XML Element for basic $xml',
    function () {
        $xml = '<Name>Matt</Name>';
        $obj = Exml::read($xml);

        expect($obj)->toBeInstanceOf(Element::class);
        expect($obj->tag())->toBe('Name');
        expect($obj->value())->toBe('Matt');
    }
);

it(
    'returns XML element with 1 child element',
    function () {
        $xml = '<Customer><Name>Matt</Name></Customer>';
        $obj = Exml::read($xml);

        expect($obj)->toBeInstanceOf(Element::class);
        expect($obj->tag())->toBe('Customer');
        expect($obj->children())->toBeArray();
        expect($obj->Name)->toBeInstanceOf(Element::class);
        expect($obj->Name->tag())->toBe('Name');
        expect($obj->Name->value())->toBe('Matt');
    }
);

it(
    'returns XML element with multiple child element',
    function () {
        $xml = '<Customer><Name>Matt</Name><Age>37</Age></Customer>';
        $obj = Exml::read($xml);

        expect($obj)->toBeInstanceOf(Element::class);
        expect($obj->tag())->toBe('Customer');
        expect($obj->children())->toBeArray();
        expect($obj->Name)->toBeInstanceOf(Element::class);
        expect($obj->Name->tag())->toBe('Name');
        expect($obj->Name->value())->toBe('Matt');
        expect($obj->Age)->toBeInstanceOf(Element::class);
        expect($obj->Age->tag())->toBe('Age');
        expect($obj->Age->value())->toBe('37');
    }
);

it(
    'returns XML element with 2 tiers of child elements',
    function () {
        $xml = '<Account><Customer><Name>Matt</Name></Customer></Account>';
        $obj = Exml::read($xml);

        expect($obj)->toBeInstanceOf(Element::class);
        expect($obj->tag())->toBe('Account');
        expect($obj->children())->toBeArray();
        expect($obj->Customer)->toBeInstanceOf(Element::class);
        expect($obj->Customer->tag())->toBe('Customer');
        expect($obj->Customer->Name)->toBeInstanceOf(Element::class);
        expect($obj->Customer->Name->tag())->toBe('Name');
        expect($obj->Customer->Name->value())->toBe('Matt');
    }
);

it(
    'can create child sibling elements with the same name by converting them to an array',
    function () {
        $xml = '<?xml version="1.0" encoding="utf-8" ?><Response><Order><Ref>123</Ref></Order><Order><Ref>456</Ref></Order></Response>';
        $exml = Exml::read($xml);

        expect($exml)->toBeInstanceOf(Container::class);
        expect($exml->tag())->toBe('Response');
        expect(count($exml->Order))->toBe(2);
        expect($exml->Order[1]->tag())->toBe('Order');
    }
);

it(
    'throws an invalid argument exception when the xml does not have a root element',
    function () {
        Exml::read('<?xml version="1.0" encoding="utf-8" ?><Response></Response><Response></Response>');
    }
)->expectException(\InvalidArgumentException::class);
