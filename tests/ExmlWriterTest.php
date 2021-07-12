<?php

use Domattr\Exml\Container;

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
