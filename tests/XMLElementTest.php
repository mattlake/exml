<?php

namespace Domattr\Exml\Tests;

use Domattr\Exml\Attribute;
use Domattr\Exml\Element;

it('can be instantiated')->expect(new Element())->toBeInstanceOf(Element::class);

it(
    'can get and set tag',
    function () {
        $el = new Element();
        expect($el->tag())->toBeNull();

        $el->setTag('Test');
        expect($el->tag())->toBe('Test');
    }
);

it(
    'can get and set namespace',
    function () {
        $el = new Element();
        expect($el->namespace())->toBeNull();

        $el->setNamespace('Test');
        expect($el->namespace())->toBe('Test');
    }
);

it(
    'can get and set attributes',
    function () {
        $el = new Element();
        expect($el->attributes())->toBeArray()->toBeEmpty();

        $el->addAttribute(new Attribute('scope="Test"'));
        expect($el->attributes())->toBeArray();
        expect($el->attributes()[0])->toBeInstanceOf(Attribute::class);
        expect($el->attributes()[0]->key())->toBe('scope');
        expect($el->attributes()[0]->value())->toBe('Test');
    }
);

it(
    'can add and retrieve children elements',
    function () {
        $parent = Element::create('Parent');
        expect($parent->children())->toBeArray()->toBeEmpty();

        $parent->addChildren(
            [
                Element::create('Test')
            ]
        );

        expect($parent->children())->toBeArray();
        expect($parent->Test)->toBeInstanceOf(Element::class);
    }
);

it(
    'can get and set a value',
    function () {
        $el = new Element();
        expect($el->value())->toBeEmpty();

        $el->setValue('Test');
        expect($el->value())->toBe('Test');
    }
);

it(
    'returns null if there is no matching child element',
    function () {
        $el = new Element();
        $el->setTag('Parent');

        expect($el->children())->toBeArray()->toBeEmpty();

        expect($el->Child)->toBeNull();
    }
);

it(
    'throws an invalid argument exception if a child is added that does not have a tag set',
    function () {
        $parent = new Element();
        expect($parent->children())->toBeArray()->toBeEmpty();

        $child = new Element();
        $parent->addChildren([$child]);
    }
)->expectException(\InvalidArgumentException::class);

it(
    'can be instantiated using the factory method',
    function () {
        $el = Element::create('soap:Envelope');

        expect($el)->toBeInstanceOf(Element::class);
        expect($el->tag())->toBe('Envelope');
        expect($el->namespace())->toBe('soap');
    }
);
