<?php
require_once(__DIR__ . '/../env_loader.php');
require_once(__DIR__ . '/../vendor/autoload.php');

use App\DBConnection;

$dbConnection = new DBConnection();
$dbConnection->emptyUploads();

$files = glob(__DIR__ .'/../../digital_signage/uploads/*');
foreach($files as $file){
    if(is_file($file)) {
        unlink($file);
    }
}