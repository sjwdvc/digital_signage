<?php
require_once('../env_loader.php');
require_once('../vendor/autoload.php');
session_start();

function connect(){
    $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
    return new PDO(env('DB_TYPE') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME') . ';charset=' . env('DB_CHARSET'), env('DB_USERNAME'), env('DB_PASSWORD'), $options);
}

function saveUploadToDatabase($url, $user, $description, $name){
    $conn = connect();
    $sql = "INSERT INTO `uploads` (`user`,`filename`, `name`, `description`) values(:email, :url, :name, :description)";
    $query = $conn->prepare($sql);
    $query->bindParam('email', $user);
    $query->bindParam('url', $url);
    $query->bindParam('name', $name);
    $query->bindParam('description', $description);
    $query->execute();
    $conn = null;
}


