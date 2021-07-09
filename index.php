<?php

require_once __DIR__ . '/XMLAttribute.php';
require_once __DIR__ . '/XMLElement.php';
require_once __DIR__ . '/XMLReader.php';
require_once __DIR__ . '/ContentDTO.php';
require_once __DIR__ . '/ContentDTOFactory.php';

$xml = htmlentities(
    '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <PlaceOrdersResponse xmlns="http://ws.bbtrack.com/OrderInterface/">
            <PlaceOrdersResult>
                <OrderResponseType>
                    <Version>V3</Version>
                    <CustomerInformation>
                        <Name>string</Name>
                        <ReferralCode>string</ReferralCode>
                        <Password>string</Password>
                    </CustomerInformation>
                    <Reference>string</Reference>
                    <OrderDate>dateTime</OrderDate>
                    <CRD>dateTime</CRD>
                    <Status>string</Status>
                    <Information>
                        <Message xsi:nil="true" />
                    </Information>
                </OrderResponseType>
                <OrderResponseType>
                    <Version>string</Version>
                    <CustomerInformation>
                        <Name>string</Name>
                        <ReferralCode>string</ReferralCode>
                        <Password>string</Password>
                    </CustomerInformation>
                    <Reference>string</Reference>
                    <OrderDate>dateTime</OrderDate>
                    <CRD>dateTime</CRD>
                    <Status>string</Status>
                    <Information>
                        <Message xsi:nil="true" />
                    </Information>
                </OrderResponseType>
            </PlaceOrdersResult>
        </PlaceOrdersResponse>
    </soap:Body>
</soap:Envelope>'
);

$simpleXML = '<Account><Customer><Name>Matt</Name></Customer></Account>';

var_dump(Mattlake\XMLReader::readXML($simpleXML));


