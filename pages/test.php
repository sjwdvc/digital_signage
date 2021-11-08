<?php
namespace MyApp;
require_once(__DIR__.'/../vendor/autoload.php');

$dbConnection = new DBConnection();
$toShow = null;

if((int)$dbConnection->checkTotalSubmissions()['totalSubmissions'] > 0){
    if($dbConnection->checkUnshown()['unshownSubmissions'] == 0){
        $dbConnection->resetShown();
    }
    $toShow = $dbConnection->getNextUnshownSubmission();
    $dbConnection->updateShown($toShow['id']);
}
if($toShow) {
    var_dump($toShow);
}
else{
    var_dump('nothing to show');
}