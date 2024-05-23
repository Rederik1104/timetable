<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

$provider = new \League\OAuth2\Client\Provider\Google(
    [
        'clientID' => '1006791770357-7g8it2mm84ptt97irhngb40o83pga3mk.apps.googleusercontent.com',
        'clientSecret' => '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',
        'redirectUri' => 'https://erik.goatserver.de',
    ]
);
