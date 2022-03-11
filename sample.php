<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Domattr\Exml\Exml;

$xml =
    '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <github:Repo>
            <RepoName>Exml</RepoName>
            <UserInformation>
                <Name>Matt Lake</Name>
                <Role>Developer</Role>
            </UserInformation>
            <Url>https://github.com/mattlake/exml</Url>
            <Url>https://packagist.org/packages/domattr/exml</Url>
            <Status>Public</Status>
        </github:Repo>
    </soap:Body>
</soap:Envelope>';

$obj = Exml::read($xml);

// Echo out the username
echo $obj->Body->Repo->UserInformation->Name->value();
