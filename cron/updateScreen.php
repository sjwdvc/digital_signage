<?php
require_once(__DIR__.'/../vendor/autoload.php');
require_once(__DIR__.'/../env_loader.php');

use WebSocket\Client;

$client = new Client('ws://'.env('domain').':'.env('wsPort'));
//TODO:send message and let the server get the next submission from the database and send to clients
$client->send('updateScreen');
$client->close();
