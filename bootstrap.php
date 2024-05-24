<?php
session_start();
require_once __DIR__ . "/vendor/autoload.php";

$provider = new \League\OAuth2\Client\Provider\Google(
    [
        'clientId' => '1006791770357-chg0uvuhkn3ni7hh7dooc4sqp47ugbuk.apps.googleusercontent.com',
        'clientSecret' => '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',
        'redirectUri' => 'https://erik.goatserver.de/google/importData.php',
    ]
);
