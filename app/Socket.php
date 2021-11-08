<?php
namespace MyApp;
require_once(__DIR__.'/../vendor/autoload.php');

use MyApp\DBConnection;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Socket implements MessageComponentInterface {

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {

        // Store the new connection in $this->clients
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        if($msg == 'updateScreen'){
            $dbConnection = new DBConnection();
            $toShow = null;

            if((int)$dbConnection->checkTotalSubmissions()['totalSubmissions'] > 0){
                if($dbConnection->checkUnshown()['unshownSubmissions'] == 0){
                    $dbConnection->resetShown();
                }
                $toShow = $dbConnection->getNextUnshownSubmission();
                $dbConnection->updateShown($toShow['id']);
            }

            foreach ( $this->clients as $client ) {
                if ( $from->resourceId == $client->resourceId ) {
                    continue;
                }
                if($toShow) {
                    $client->send(json_encode([
                        'success' => true,
                        'data' => $toShow,
                        'message' => ''
                        ]));
                }
                else{
                    $client->send(json_encode([
                        'success' => false,
                        'data' => [],
                        'message' => 'Nothing to show'
                    ]));
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }

    public function sendToClients($user, $description, $url){
        $message = [
            'user' => $user,
            'description' => $description,
            'url' => $url
        ];
        foreach ( $this->clients as $client ) {
            $client->send(json_encode($message));
        }
    }
}