<?php
$tenant = '';

$variables = [
    //Domain
    'domain' => '',
    'wsPort' => '',
    'subFolder' => '',
    'appFolder' => '',

    //upload
    'uploadFolder' => '/uploads',

    //DB
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '',
    'DB_CHARSET' => 'utf8',
    'DB_USERNAME' => '',
    'DB_PASSWORD' => '',
    'DB_NAME' => '',
    'DB_PORT' => '3306',

    //Oath2
    'clientId' => '',
    'clientSecret' => '',
    'tenant' => '',
    'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
];
$variables['httpProtocol'] = $variables['domain'] != 'localhost' ? 'https://' : 'http://';

$variables['uploadUrl'] = $variables['httpProtocol'] . $variables['domain'].$variables['subFolder'];
$variables['fetchUri'] = $variables['httpProtocol'].$variables['domain'].$variables['subFolder'].$variables['appFolder'].'/app/handleUpload.php';


$variables['urlAuthorize'] = 'https://login.microsoftonline.com/'. $variables['tenant'] .'/oauth2/v2.0/authorize?';
$variables['urlAccessToken'] = 'https://login.microsoftonline.com/'. $variables['tenant'] .'/oauth2/v2.0/token';
$variables['redirectUri'] = $variables['httpProtocol'] . $variables['domain'].$variables['subFolder'] .'/index.php';

foreach ($variables as $key => $value) {
    putenv("$key=$value");
}
$tenant = null;