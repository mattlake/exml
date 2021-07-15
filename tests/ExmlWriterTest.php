<?php

use Domattr\Exml\Attribute;
use Domattr\Exml\Element;
use Domattr\Exml\RootElement;

it('can write a simple object to xml')
    ->expect(RootElement::create('Response', '1.1', 'utf-8')->toXML())
    ->toBe('<?xml version="1.1" encoding="utf-8"?><Response></Response>');

it('can write a simple object to xml that has a namespace')
    ->expect(RootElement::create('soap:Response', '1.1', 'utf-8')->toXML())
    ->toBe('<?xml version="1.1" encoding="utf-8"?><soap:Response></soap:Response>');

it('can write a simple object to xml that has an attribute')
    ->expect(RootElement::create('Response', '1.1', 'utf-8')->addAttribute(new Attribute('mode="test"'))->toXML())
    ->toBe('<?xml version="1.1" encoding="utf-8"?><Response mode="test"></Response>');

it('can write a simple object with a value to xml')
    ->expect(RootElement::create('Response', '1.1', 'utf-8')->setValue('test')->toXML())
    ->toBe('<?xml version="1.1" encoding="utf-8"?><Response>test</Response>');

it('can write a simple object with a single child element')
    ->expect(
        RootElement::create('Response', '1.1', 'utf-8')
            ->addChildren(
                [
                    Element::create('Name')
                ]
            )
            ->toXML()
    )->toBe('<?xml version="1.1" encoding="utf-8"?><Response><Name></Name></Response>');

it('can write a simple object with a nested element containing a value')
    ->expect(
        RootElement::create('Response', '1.1', 'utf-8')
            ->addChildren(
                [
                    Element::create('Name')->setValue('Matt')
                ]
            )
            ->toXML()
    )->toBe('<?xml version="1.1" encoding="utf-8"?><Response><Name>Matt</Name></Response>');

it('can write a simple object with a nested sibling elements')
    ->expect(
        RootElement::create('Response', '1.1', 'utf-8')
            ->addChildren(
                [
                    Element::create('Name')->setValue('Matt'),
                    Element::create('Role')->setValue('Developer'),
                ]
            )
            ->toXML()
    )
    ->toBe('<?xml version="1.1" encoding="utf-8"?><Response><Name>Matt</Name><Role>Developer</Role></Response>');

it('can build XML from a complex object')
    ->expect(
        RootElement::create('soap:Envelope')
            ->addAttribute(new Attribute('xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'))
            ->addAttribute(new Attribute('xmlns:xsd="http://www.w3.org/2001/XMLSchema"'))
            ->addAttribute(new Attribute('xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"'))
            ->addChildren(
                [
                    Element::create('soap:Body')->addChildren(
                        [
                            Element::create('github:Repo')->addChildren(
                                [
                                    Element::create('RepoName')->setValue('Exml'),
                                    Element::create('UserInformation')->addChildren(
                                        [
                                            Element::create('Name')->setValue('Matt Lake'),
                                            Element::create('Role')->setValue('Developer'),
                                        ]
                                    ),
                                    Element::create('Url')->setValue('https://github.com/mattlake/exml'),
                                    Element::create('Url')->setValue('https://packagist.org/packages/domattr/exml'),
                                    Element::create('Status')->setValue('Public'),
                                ]
                            ),
                        ]
                    ),
                ]
            )
            ->toXML()
    )->toBe(
        '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><github:Repo><RepoName>Exml</RepoName><UserInformation><Name>Matt Lake</Name><Role>Developer</Role></UserInformation><Url>https://github.com/mattlake/exml</Url><Url>https://packagist.org/packages/domattr/exml</Url><Status>Public</Status></github:Repo></soap:Body></soap:Envelope>'
    );
