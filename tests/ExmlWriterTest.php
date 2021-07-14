<?php

use Domattr\Exml\Attribute;
use Domattr\Exml\Container;
use Domattr\Exml\Element;

it('can write a simple object to xml', function () {
    $container = new Container();
    $container->setVersion('1.1');
    $container->setEncoding('utf-8');
    $container->setTag('Response');

    $expected = '<?xml version="1.1" encoding="utf-8"?><Response></Response>';

    expect($container->toXML())->toBe($expected);
});

it('can write a simple object to xml that has a namespace', function () {
    $container = new Container();
    $container->setVersion('1.1');
    $container->setEncoding('utf-8');
    $container->setTag('Response');
    $container->setNamespace('soap');

    $expected = '<?xml version="1.1" encoding="utf-8"?><soap:Response></soap:Response>';

    expect($container->toXML())->toBe($expected);
});

it('can write a simple object to xml that has an attribute', function () {
    $container = new Container();
    $container->setVersion('1.1');
    $container->setEncoding('utf-8');
    $container->setTag('Response');
    $container->addAttribute(new Attribute('mode="test"'));

    $expected = '<?xml version="1.1" encoding="utf-8"?><Response mode="test"></Response>';

    expect($container->toXML())->toBe($expected);
});

it('can write a simple object with a value to xml', function () {
    $container = new Container();
    $container->setVersion('1.1');
    $container->setEncoding('utf-8');
    $container->setTag('Response');
    $container->setValue('test');

    $expected = '<?xml version="1.1" encoding="utf-8"?><Response>test</Response>';

    expect($container->toXML())->toBe($expected);
});

it('can write a simple object with a nested element', function () {
    $container = new Container();
    $container->setVersion('1.1');
    $container->setEncoding('utf-8');
    $container->setTag('Response');

    $el = new Element();
    $el->setTag('Name');

    $container->addChild($el);

    $expected = '<?xml version="1.1" encoding="utf-8"?><Response><Name></Name></Response>';

    expect($container->toXML())->toBe($expected);
});
