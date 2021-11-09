<?php

namespace MyApp;

require_once(__DIR__.'/../env_loader.php');
require_once(__DIR__.'/../vendor/autoload.php');

use \PDO;

class DBConnection{

    function connect(){
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
        return new PDO(env('DB_TYPE') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME') . ';charset=' . env('DB_CHARSET'), env('DB_USERNAME'), env('DB_PASSWORD'), $options);
    }

    function saveUploadToDatabase($url, $user, $description, $name){
        $now = date("Y-m-d H:i:s");
        $conn = $this->connect();
        $sql = "INSERT INTO `uploads` (`user`,`filename`, `name`, `description`, `created_at`) values(:email, :url, :name, :description, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam('email', $user);
        $query->bindParam('url', $url);
        $query->bindParam('name', $name);
        $query->bindParam('description', $description);
        $query->bindParam('created_at', $now);
        $query->execute();
        $conn = null;
    }

    function checkTotalSubmissions(){
        $conn = $this->connect();
        $sql = "SElECT count(*) AS `totalSubmissions` FROM `uploads`";
        $query = $conn->prepare($sql);
        $query->execute();
        $conn = null;
        return $query->fetch();
    }

    function checkUnshown(){
        $conn = $this->connect();
        $sql = "SElECT count(*) AS `unshownSubmissions` FROM `uploads` where `shown` = 0";
        $query = $conn->prepare($sql);
        $query->execute();
        $conn = null;
        return $query->fetch();
    }

    function getNextUnshownSubmission(){
        $conn = $this->connect();
        $sql = "SElECT * FROM `uploads` where `shown` = 0 order by `created_at` ASC LIMIT 1";
        $query = $conn->prepare($sql);
        $query->execute();
        $conn = null;

        return $query->fetch();
    }

    function updateShown($id){
        $conn = $this->connect();
        $sql = "UPDATE `uploads` SET `shown` = 1 WHERE id=:id";
        $query = $conn->prepare($sql);
        $query->bindParam('id', $id);
        $query->execute();
        $conn = null;
    }
    function resetShown(){
        $conn = $this->connect();
        $sql = "UPDATE `uploads` SET `shown` = 0";
        $query = $conn->prepare($sql);
        $query->execute();
        $conn = null;
    }
    function emptyUploads(){
        $conn = $this->connect();
        $sql = "DELETE FROM `uploads`";
        $query = $conn->prepare($sql);
        $query->execute();
        $conn = null;
    }
}