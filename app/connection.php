<?php
require_once('../env_loader.php');
require_once('../vendor/autoload.php');
session_start();

function connect(){
    $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
    return new PDO(env('DB_TYPE') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME') . ';charset=' . env('DB_CHARSET'), env('DB_USERNAME'), env('DB_PASSWORD'), $options);
}

function saveUploadToDatabase($url){
    $conn = connect();
    $sql = "INSERT INTO `uploads` (`user`,`filename`) values(:email, :url)";
    $query = $conn->prepare($sql);
    $query->bindParam('email', $_SESSION['user']);
    $query->bindParam('url', $url);
    $query->execute();
    $conn = null;
}


