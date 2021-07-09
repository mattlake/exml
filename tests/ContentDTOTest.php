<?php

use Mattlake\ContentDTO;
use Mattlake\ContentDTOFactory;

require_once __DIR__ . '/../ContentDTO.php';
require_once __DIR__ . '/../ContentDTOFactory.php';

it(
    'can instantiate a DTO with a simple valid string',
    function () {
        $xml = '<Name>Matt</Name>';
        $dto = ContentDTOFactory::create($xml);

        expect($dto)->toBeInstanceOf(ContentDTO::class);
        expect($dto->tag())->toBe('Name');
        expect($dto->attributes())->toBe('');
        expect($dto->content())->toBe('Matt');
    }
);

it(
    'can instantiate a DTO with a valid string containing a namespace',
    function () {
        $xml = '<test:Name>Matt</test:Name>';
        $dto = ContentDTOFactory::create($xml);

        expect($dto)->toBeInstanceOf(ContentDTO::class);
        expect($dto->tag())->toBe('test:Name');
        expect($dto->attributes())->toBe('');
        expect($dto->content())->toBe('Matt');
    }
);

it(
    'can instantiate a DTO with a valid string containing attributes',
    function () {
        $xml = '<Name role="admin">Matt</Name>';
        $dto = ContentDTOFactory::create($xml);

        expect($dto)->toBeInstanceOf(ContentDTO::class);
        expect($dto->tag())->toBe('Name');
        expect($dto->attributes())->toBe('role="admin"');
        expect($dto->content())->toBe('Matt');
    }
);

it(
    'can instantiate a DTO with a valid string containing no content',
    function () {
        $xml = '<Name></Name>';
        $dto = ContentDTOFactory::create($xml);

        expect($dto)->toBeInstanceOf(ContentDTO::class);
        expect($dto->tag())->toBe('Name');
        expect($dto->attributes())->toBe('');
        expect($dto->content())->toBe('');
    }
);

it(
    'can instantiate a DTO with a valid string containing a self closing tag',
    function () {
        $xml = '<Name />';
        $dto = ContentDTOFactory::create($xml);

        expect($dto)->toBeInstanceOf(ContentDTO::class);
        expect($dto->tag())->toBe('Name');
        expect($dto->attributes())->toBe('');
        expect($dto->content())->toBe('');
    }
);

it(
    'returns provided argument if not valid',
    function () {
        $xml = 'Name';
        $dto = ContentDTOFactory::create($xml);

        expect($dto)->toBe('Name');
    }
);

it(
    'returns an array of DTOs if sibling elements are sent',
    function () {
        $xml = '<name>Matt</name><age>37</age>';
        $dto = ContentDTOFactory::create($xml);

        expect($dto)->toMatchArray([ContentDTOFactory::create('<name>Matt</name>'), ContentDTOFactory::create('<age>37</age>')]);
    }
);