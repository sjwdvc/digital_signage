<?php
$tenant = 'YOUR TENANT CODE HERE';

$variables = [
    'DB_HOST' => 'localhost',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => '',
    'DB_NAME' => 'digital_signage',
    'DB_PORT' => '3306',

    'domain' => 'localhost',
    'wsPort' => '8080',
    'objectId' => '',
    'clientId' => '',
    'clientSecret' => '',
    'redirectUri' => 'Call back route',
    'tenant' => '',
    'urlAuthorize' => 'https://login.microsoftonline.com/'. $tenant .'/oauth2/v2.0/authorize?',
    'urlAccessToken' => 'https://login.microsoftonline.com/'. $tenant .'/oauth2/v2.0/token',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',

];

foreach ($variables as $key => $value) {
    putenv("$key=$value");
}
$tenant = null;