<?php

use Domattr\Exml\Container;

it(
    'can be instantiated with all parameters provided',
    function () {
        $dto = \Domattr\Exml\ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><Response>String</></Response>');
        expect(new Container($dto))
            ->toBeInstanceOf(Container::class);
    }
);

it(
    'can be instantiated when no parameters are provided',
    function () {
        $dto = \Domattr\Exml\ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><Response>String</Response>');
        expect(new Container($dto))
            ->toBeInstanceOf(Container::class);
    }
);

it(
    'can set and get the version',
    function () {
        $dto = \Domattr\Exml\ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><Response>String</Response>');
        $container = new Container($dto);
        expect($container->version())->toBe("1.0");

        $container->setVersion("1.1");
        expect($container->version())->toBe("1.1");
    }
);

it(
    'can set and get the encoding',
    function () {
        $dto = \Domattr\Exml\ContentDTOFactory::create('<?xml version="1.0" encoding="utf-8" ?><Response>String</Response>');
        $container = new Container($dto);
        expect($container->encoding())->toBe("utf-8");

        $container->setEncoding("utf-4");
        expect($container->encoding())->toBe("utf-4");
    }
);