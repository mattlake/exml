<?php

namespace Domattr\XMLReader\Tests;

use Domattr\XMLReader\XMLAttribute;
use Domattr\XMLReader\XMLElement;

it(
    'can be instantiated',
    function () {
        expect(new XMLElement())->toBeInstanceOf(XMLElement::class);
    }
);

it(
    'can get and set tag',
    function () {
        $el = new XMLElement();
        expect($el->tag())->toBeNull();

        $el->setTag('Test');
        expect($el->tag())->toBe('Test');
    }
);

it(
    'can get and set namespace',
    function () {
        $el = new XMLElement();
        expect($el->namespace())->toBeNull();

        $el->setNamespace('Test');
        expect($el->namespace())->toBe('Test');
    }
);

it(
    'can get and set attributes',
    function () {
        $el = new XMLElement();
        expect($el->attributes())->toBeArray()->toBeEmpty();

        $el->addAttribute(new XMLAttribute('scope="Test"'));
        expect($el->attributes())->toBeArray();
        expect($el->attributes()[0])->toBeInstanceOf(XMLAttribute::class);
        expect($el->attributes()[0]->key())->toBe('scope');
        expect($el->attributes()[0]->value())->toBe('Test');
    }
);

it(
    'can add and retrieve children elements',
    function () {
        $parent = new XMLElement();
        expect($parent->children())->toBeArray()->toBeEmpty();

        $child = new XMLElement();
        $child->setTag('Test');
        $parent->addChild($child);
        expect($parent->children())->toBeArray();
        expect($parent->Test)->toBeInstanceOf(XMLElement::class);
    }
);

it(
    'can get and set a value',
    function () {
        $el = new XMLElement();
        expect($el->value())->toBeNull();

        $el->setValue('Test');
        expect($el->value())->toBe('Test');
    }
);

it('can retrieve children using magic methods', function () {
    $el = new XMLElement();
    $el->setTag('Parent');

    expect($el->children())->toBeArray()->toBeEmpty();

    $child = new XMLElement();
    $child->setTag('Child');

    $el->addChild($child);

    expect($el->Child)->toBeInstanceOf(XMLElement::class);
});

it('returns null if there is no matching child element', function () {
    $el = new XMLElement();
    $el->setTag('Parent');

    expect($el->children())->toBeArray()->toBeEmpty();

    expect($el->Child)->toBeNull();
});
