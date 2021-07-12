<?php

use Domattr\Exml\Container;

it('can write a simple object to xml', function () {
    $container = new Container();
    $container->setVersion('1.1');
    $container->setEncoding('utf-8');

    $expected = '<?xml version="1.1" encoding="utf-8"?>';

    expect($container->toXML())->toBe($expected);
});
