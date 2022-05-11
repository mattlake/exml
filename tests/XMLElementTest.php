<?php

namespace Domattr\Exml\Tests;

use Domattr\Exml\Attribute;
use Domattr\Exml\Element;

it(
    'can be instantiated',
    function () {
        expect(new Element())->toBeInstanceOf(Element::class);
    }
);

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
        expect($el->attributes()['scope'])->toBeInstanceOf(Attribute::class);
        expect($el->attributes()['scope']->value())->toBe('Test');
    }
);

it(
    'can add and retrieve children elements',
    function () {
        $parent = new Element();
        expect($parent->children())->toBeArray()->toBeEmpty();

        $child = new Element();
        $child->setTag('Test');
        $parent->addChild($child);
        expect($parent->children())->toBeArray();
        expect($parent->Test)->toBeInstanceOf(Element::class);
    }
);

it(
    'can get and set a value',
    function () {
        $el = new Element();
        expect($el->value())->toBeNull();

        $el->setValue('Test');
        expect($el->value())->toBe('Test');
    }
);

it('can retrieve children using magic methods', function () {
    $el = new Element();
    $el->setTag('Parent');

    expect($el->children())->toBeArray()->toBeEmpty();

    $child = new Element();
    $child->setTag('Child');

    $el->addChild($child);

    expect($el->Child)->toBeInstanceOf(Element::class);
});

it('returns null if there is no matching child element', function () {
    $el = new Element();
    $el->setTag('Parent');

    expect($el->children())->toBeArray()->toBeEmpty();

    expect($el->Child)->toBeNull();
});
