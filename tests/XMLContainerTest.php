<?php

use Domattr\Exml\Attribute;
use Domattr\Exml\Container;

it('can be instantiated with all parameters provided')
    ->expect(new Container(version: "1.0", encoding: "utf-8"))
    ->toBeInstanceOf(Container::class);

it('can be instantiated when no parameters are provided')
    ->expect(new Container())
    ->toBeInstanceOf(Container::class);

it('can set and get the version', function(){
    $container = new Container();
    expect($container->version())->toBe("1.0");

    $container->setVersion("1.1");
    expect($container->version())->toBe("1.1");
});

it('can set and get the encoding', function(){
    $container = new Container();
    expect($container->encoding())->toBe("utf-8");

    $container->setEncoding("utf-4");
    expect($container->encoding())->toBe("utf-4");
});

it(
    'can get and set attributes',
    function () {
        $el = new Container();
        expect($el->attributes())->toBeArray()->toBeEmpty();

        $el->addAttribute(new Attribute('scope="Test"'));
        expect($el->attributes())->toBeArray();
        expect($el->attributes()[0])->toBeInstanceOf(Attribute::class);
        expect($el->attributes()[0]->key())->toBe('scope');
        expect($el->attributes()[0]->value())->toBe('Test');
    }
);