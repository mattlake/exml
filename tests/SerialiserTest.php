<?php

use Domattr\Exml\Exceptions\ClassNotFoundException;
use Domattr\Exml\Exml;
use Domattr\Exml\Tests\Fixtures\SimpleUser;

it('Can read simple single layer xml into expected POPO', function () {
    $xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<User>
    <FirstName>Matthew</FirstName>
    <LastName>Lake</LastName>
</User>
XML;

    $user = Exml::read($xml)->into(SimpleUser::class);

    expect($user->FirstName)->toBe('Matthew');
    expect($user->LastName)->toBe('Lake');
});

it('Returns an error if the class cannotbe found', function () {
    $xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<User>
    <FirstName>Matthew</FirstName>
    <LastName>Lake</LastName>
</User>
XML;

    Exml::read($xml)->into(GuffClass::class);
})->throws(ClassNotFoundException::class);

it('should ignore any elements that are not in the model', function () {
    $xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<User>
    <FirstName>Matthew</FirstName>
    <LastName>Lake</LastName>
    <GuffElement>This is just guff</GuffElement>
</User>
XML;

    $user = Exml::read($xml)->into(SimpleUser::class);

    expect($user->FirstName)->toBe('Matthew');
    expect($user->LastName)->toBe('Lake');
});

it('can populate properties that are also classes', function () {
    $xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<User>
    <FirstName>Matthew</FirstName>
    <LastName>Lake</LastName>
    <Job>
        <Title>Developer</Title>
        <Language>Some</Language>
    </Job>
</User>
XML;

    $user = Exml::read($xml)->into(SimpleUser::class);

    expect($user->FirstName)->toBe('Matthew');
    expect($user->LastName)->toBe('Lake');
    expect($user->Job->Title)->toBe('Developer');
    expect($user->Job->Language)->toBe('Some');
});
