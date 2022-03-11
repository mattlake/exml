<?php

use Domattr\Exml\Exceptions\ClassNotFoundException;
use Domattr\Exml\Exml;
use Domattr\Exml\Tests\Fixtures\SimpleUser;

it('Can read simple single layer xml into expected POPO', function () {
    $xml = '<?xml version="1.0" encoding="utf-8"?>
<User>
 <FirstName>Matthew</FirstName>
 <LastName>Lake</LastName>
</User>';

    $user = Exml::read($xml)->into(SimpleUser::class);

    expect($user->FirstName)->toBe('Matthew');
    expect($user->LastName)->toBe('Lake');
});

it('Returns an error if the class cannotbe found', function () {
    $xml = '<?xml version="1.0" encoding="utf-8"?>
<User>
 <FirstName>Matthew</FirstName>
 <LastName>Lake</LastName>
</User>';

    $user = Exml::read($xml)->into(GuffClass::class);
})->throws(ClassNotFoundException::class);