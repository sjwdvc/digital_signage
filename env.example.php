<?php
$tenant = '';

$variables = [
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_CHARSET' => 'utf8',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => '',
    'DB_NAME' => '',
    'DB_PORT' => '3306',

    'domain' => '',
    'wsPort' => '8080',
    'objectId' => '',
    'clientId' => '',
    'clientSecret' => '',
    'redirectUri' => '',
    'fetchUri' => '',
    'tenant' => '',
    'urlAuthorize' => 'https://login.microsoftonline.com/'. $tenant .'/oauth2/v2.0/authorize?',
    'urlAccessToken' => 'https://login.microsoftonline.com/'. $tenant .'/oauth2/v2.0/token',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',

    'uploadFolder' => 'uploads/',
    'uploadUrl' => ''

];

foreach ($variables as $key => $value) {
    putenv("$key=$value");
}
$tenant = null;