<?php

use Domattr\Exml\Container;
use Domattr\Exml\ContentDTOFactory;

it('can be instantiated with all parameters provided')
    ->expect(new Container(ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><Response>String</></Response>')))
    ->toBeInstanceOf(Container::class);


it('can be instantiated when no parameters are provided')
    ->expect(new Container(ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><Response>String</></Response>')))
    ->toBeInstanceOf(Container::class);

it(
    'can set and get the version',
    function () {
        $dto = \Domattr\Exml\ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><Response>String</Response>');
        $container = new Container();
        $container->hydrate($dto);
        expect($container->version())->toBe("1.0");

        $container->setVersion("1.1");
        expect($container->version())->toBe("1.1");
    }
);

it(
    'can set and get the encoding',
    function () {
        $dto = \Domattr\Exml\ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><Response>String</Response>');
        $container = new Container();
        $container->hydrate($dto);
        expect($container->encoding())->toBe("utf-8");

        $container->setEncoding("utf-4");
        expect($container->encoding())->toBe("utf-4");
    }
);

it('can get and set attributes', function(){
    $dto = \Domattr\Exml\ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><Response type="test" active="true">String</Response>');
    $container = new Container();
    $container->hydrate($dto);
    expect(count($container->attributes()))->toBe(2);
});

it('can create namespace and tag on element during creation', function(){
    $dto = \Domattr\Exml\ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><soap:Response>String</soap:Response>');
    $container = new Container();
    $container->hydrate($dto);
    expect($container->namespace())->toBe('soap');
});
