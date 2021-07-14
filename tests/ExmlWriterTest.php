<?php

use Domattr\Exml\Attribute;
use Domattr\Exml\Container;
use Domattr\Exml\ContentDTOFactory;
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

it('can write a simple object with a nested element containing a value', function () {
    $container = new Container();
    $container->setVersion('1.1');
    $container->setEncoding('utf-8');
    $container->setTag('Response');

    $el = new Element();
    $el->setTag('Name');
    $el->setValue('Matt');

    $container->addChild($el);

    $expected = '<?xml version="1.1" encoding="utf-8"?><Response><Name>Matt</Name></Response>';

    expect($container->toXML())->toBe($expected);
});

it('can write a simple object with a nested sibling elements', function () {
    $container = new Container();
    $container->setVersion('1.1');
    $container->setEncoding('utf-8');
    $container->setTag('Response');

    $el = new Element();
    $el->setTag('Name');
    $el->setValue('Matt');

    $el2 = new Element();
    $el2->setTag('Role')->setValue('Developer');

    $container->addChild($el);
    $container->addChild($el2);

    $expected = '<?xml version="1.1" encoding="utf-8"?><Response><Name>Matt</Name><Role>Developer</Role></Response>';

    expect($container->toXML())->toBe($expected);
});

it('can build XML from a complex object', function () {
    $expected = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><github:Repo><RepoName>Exml</RepoName><UserInformation><Name>Matt Lake</Name><Role>Developer</Role></UserInformation><Url>https://github.com/mattlake/exml</Url><Url>https://packagist.org/packages/domattr/exml</Url><Status>Public</Status></github:Repo></soap:Body></soap:Envelope>';

    $container = (new Container())->setTag('Envelope')->setNamespace('soap')->addAttribute(new Attribute('xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'))->addAttribute(new Attribute('xmlns:xsd="http://www.w3.org/2001/XMLSchema"'))->addAttribute(new Attribute('xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"'));

    $body = (new Element())->setTag('Body')->setNamespace('soap');
    $repo = (new Element())->setTag('Repo')->setNamespace('github');
    $repoName = (new Element())->setTag('RepoName')->setValue('Exml');
    $userInformation = (new Element())->setTag('UserInformation');
    $name = (new Element())->setTag('Name')->setValue('Matt Lake');
    $role = (new Element())->setTag('Role')->setValue('Developer');
    $url1 = (new Element())->setTag('Url')->setValue('https://github.com/mattlake/exml');
    $url2 = (new Element())->setTag('Url')->setValue('https://packagist.org/packages/domattr/exml');
    $status = (new Element())->setTag('Status')->setValue('Public');

    // $userInformation->addChild($name);
    // $userInformation->addChild($role);
    $repo->addChild($repoName);
    $repo->addChild($userInformation);
    $repo->addChild($url1);
    $repo->addChild($url2);
    $repo->addChild($status);
    $container->addChild($body)->addChild($repo);
    print_r($container);
    expect($container->toXML())->toBe($expected);
});
