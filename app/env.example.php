<?php
$tenant = '';

$variables = [
    //Domain
    'domain' => 'localhost',
    'wsPort' => '8181',
    'retryTimout' => '300',
    'subFolder' => '/digital_signage/digital_signage',
//    'appFolder' => '/signage',
    'appFolder' => '',
    'pagesFolder' => '/pages',

    //upload
    'uploadFolder' => '/uploads',

    //pokes
    'timeout' => 5,

    //DB
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'db',
    'DB_CHARSET' => 'utf8',
    'DB_USERNAME' => 'root',
    'DB_PASSWORD' => 'mysql',
    'DB_NAME' => 'digital_signage',
    'DB_PORT' => '3306',

    //Oath2
    'clientId' => '',
    'clientSecret' => '',
    'tenant' => $tenant,
    'urlAuthorize' => 'https://login.microsoftonline.com/'. $tenant .'/oauth2/v2.0/authorize?',
    'urlAccessToken' => 'https://login.microsoftonline.com/'. $tenant .'/oauth2/v2.0/token',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
];
$variables['httpProtocol'] = $variables['domain'] != 'localhost' ? 'https://' : 'http://';
$variables['wsProtocol'] = $variables['domain'] != 'localhost' ? 'wss' : 'ws';
$variables['wssInUrlOrThroughPort'] = $variables['domain'] != 'localhost' ? '/wss' : ':'.$variables['wsPort'];

$variables['uploadUrl'] = $variables['httpProtocol'] . $variables['domain'].$variables['subFolder'];
$variables['fetchUri'] = $variables['httpProtocol'].$variables['domain'].$variables['subFolder'].$variables['pagesFolder'].'/handleUpload.php';
$variables['pokeUri'] = $variables['httpProtocol'].$variables['domain'].$variables['subFolder'].$variables['pagesFolder'].'/updateScreenAfterPoke.php';

$variables['redirectUri'] = $variables['httpProtocol'] . $variables['domain'].$variables['subFolder'].$variables['pagesFolder'].'/authentication.php';

foreach ($variables as $key => $value) {
    putenv("$key=$value");
}
$tenant = null;