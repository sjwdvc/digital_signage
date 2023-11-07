<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../env_loader.php');

use App\DBConnection;
use WebSocket\Client;

$dbConnection = new DBConnection();
$toShow = null;

if((int)$dbConnection->checkTotalSubmissions()['totalSubmissions'] > 0){
    if($dbConnection->checkUnshown()['unshownSubmissions'] == 0){
        $dbConnection->resetShown();
    }
    $toShow = $dbConnection->getNextUnshownSubmission();
    $dbConnection->updateShown($toShow['id']);
}
$client = new Client('ws://'.env('domain').':'.env('wsPort'));

if($toShow) {
    $client->send(json_encode(['action' => 'updateScreen', 'foundNew'=> true, 'data' => $toShow]));
}
else{
    $client->send(json_encode(['action' => 'updateScreen', 'foundNew'=> false, 'data' => []]));
}
$client->close();