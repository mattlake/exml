<?php

namespace Domattr\Exml\Tests;

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
