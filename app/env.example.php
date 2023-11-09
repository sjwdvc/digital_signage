<?php
$tenant = '';

$variables = [
    //Domain
    'domain' => '',
//    'domain' => '',
    'wsPort' => '',
    'subFolder' => '',
//    'appFolder' => '',
    'appFolder' => '',
    'pagesFolder' => '',

    //upload
    'uploadFolder' => '',
//    'uploadUrl' => '',
//    'fetchUri' => '',

    //pokes
    'timeout' => 5,

    //DB
    'DB_TYPE' => '',
    'DB_HOST' => '',
//    'DB_HOST' => '',
    'DB_CHARSET' => '',
    'DB_USERNAME' => '',
//    'DB_USERNAME' => '',
    'DB_PASSWORD' => '',
//    'DB_PASSWORD' => ':',
    'DB_NAME' => '',
//    'DB_NAME' => '',
    'DB_PORT' => '',

    //Oath2
//    'objectId' => '',
    'clientId' => 'm',
    'clientSecret' => 'm',
//    'redirectUri' => '',
    'tenant' => 'm',
    'urlAuthorize' => 'https://login.microsoftonline.com/'. $tenant .'/oauth2/v2.0/authorize?',
    'urlAccessToken' => 'https://login.microsoftonline.com/'. $tenant .'/oauth2/v2.0/token',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
];
$variables['httpProtocol'] = $variables['domain'] != 'localhost' ? 'https://' : 'http://';

$variables['uploadUrl'] = $variables['httpProtocol'] . $variables['domain'].$variables['subFolder'];
$variables['fetchUri'] = $variables['httpProtocol'].$variables['domain'].$variables['subFolder'].$variables['pagesFolder'].'/handleUpload.php';
$variables['pokeUri'] = $variables['httpProtocol'].$variables['domain'].$variables['subFolder'].$variables['pagesFolder'].'/updateScreenAfterPoke.php';


$variables['urlAuthorize'] = 'https://login.microsoftonline.com/'. $variables['tenant'] .'/oauth2/v2.0/authorize?';
$variables['urlAccessToken'] = 'https://login.microsoftonline.com/'. $variables['tenant'] .'/oauth2/v2.0/token';
$variables['redirectUri'] = $variables['httpProtocol'] . $variables['domain'].$variables['subFolder'] .'/index.php';

foreach ($variables as $key => $value) {
    putenv("$key=$value");
}
$tenant = null;