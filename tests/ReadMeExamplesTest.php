<?php

use Domattr\Exml\Exml;

it(
    'can create the expected xml string form the sample code in the readme',
    function () {
        $root = \Domattr\Exml\RootElement::create('Response');

        $root->addChildren(
            [
                \Domattr\Exml\Element::create('OrderNumber')->setValue('123456'),
                \Domattr\Exml\Element::create('OrderDate')->setValue('2021-07-15'),

            ]
        );

        $xml = $root->toXML();

        $expected = '<?xml version="1.0" encoding="utf-8"?><Response><OrderNumber>123456</OrderNumber><OrderDate>2021-07-15</OrderDate></Response>';

        expect($xml)->toBe($expected);
    }
);

it('can correctly process the read example from the readme', function(){
    $xml='<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <github:Repo>
            <RepoName>Exml</RepoName>
            <UserInformation>
                <Name>Matt Lake</Name>
                <Role>Developer</Role>
            </UserInformation>
            <Url>https://github.com/mattlake/exml</Url>
            <Status>Public</Status>
        </github:Repo>
    </soap:Body>
</soap:Envelope>';

    $obj = Exml::read($xml);

    expect($obj->version())->toBe('1.0');
    expect($obj->encoding())->toBe('utf-8');
    expect($obj->namespace())->toBe('soap');
    expect($obj->tag())->toBe('Envelope');
    expect(count($obj->attributes()))->toBe(3);

    expect($obj->Body->namespace())->toBe('soap');
    expect($obj->Body->tag())->toBe('Body');
    expect(count($obj->Body->children()))->toBe(1);

    expect($obj->Body->Repo->namespace())->toBe('github');
    expect($obj->Body->Repo->tag())->toBe('Repo');
    expect(count($obj->Body->Repo->children()))->toBe(4);

    expect($obj->Body->Repo->RepoName->value())->toBe('Exml');
    expect($obj->Body->Repo->Url->value())->toBe('https://github.com/mattlake/exml');
    expect($obj->Body->Repo->Status->value())->toBe('Public');

    expect($obj->Body->Repo->UserInformation->Name->value())->toBe('Matt Lake');
    expect($obj->Body->Repo->UserInformation->Role->value())->toBe('Developer');
});