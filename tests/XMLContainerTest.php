<?php

use Domattr\XMLReader\XMLAttribute;
use Domattr\XMLReader\XMLContainer;

it('can be instantiated with all parameters provided')
    ->expect(new XMLContainer(version: "1.0", encoding: "utf-8"))
    ->toBeInstanceOf(XMLContainer::class);

it('can be instantiated when no parameters are provided')
    ->expect(new XMLContainer())
    ->toBeInstanceOf(XMLContainer::class);

it('can set and get the version', function(){
    $container = new XMLContainer();
    expect($container->version())->toBe("1.0");

    $container->setVersion("1.1");
    expect($container->version())->toBe("1.1");
});

it('can set and get the encoding', function(){
    $container = new XMLContainer();
    expect($container->encoding())->toBe("utf-8");

    $container->setEncoding("utf-4");
    expect($container->encoding())->toBe("utf-4");
});

it(
    'can get and set attributes',
    function () {
        $el = new XMLContainer();
        expect($el->attributes())->toBeArray()->toBeEmpty();

        $el->addAttribute(new XMLAttribute('scope="Test"'));
        expect($el->attributes())->toBeArray();
        expect($el->attributes()[0])->toBeInstanceOf(XMLAttribute::class);
        expect($el->attributes()[0]->key())->toBe('scope');
        expect($el->attributes()[0]->value())->toBe('Test');
    }
);