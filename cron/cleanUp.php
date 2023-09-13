<?php
require_once(__DIR__.'/../vendor/autoload.php');
require_once(__DIR__.'/../env_loader.php');

use MyApp\DBConnection;

$dbConnection = new DBConnection();
$dbConnection->emptyUploads();

$files = glob(__DIR__ . '/../uploads/*');
foreach($files as $file){
    if(is_file($file)) {
        unlink($file);
    }
}