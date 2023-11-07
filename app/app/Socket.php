<?php
namespace App;
//require_once(__DIR__.'/../vendor/autoload.php');

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Socket implements MessageComponentInterface {

    private $clients;
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
        $message = json_decode($msg);
        if($message->action == 'updateScreen'){
            foreach ( $this->clients as $client ) {
                if ( $from->resourceId == $client->resourceId ) {
                    continue;
                }
                $client->send(json_encode($message));
            }
        }
//        else{
//            foreach ( $this->clients as $client ) {
//                if ( $from->resourceId == $client->resourceId ) {
//                    continue;
//                }
//                $client->send(json_encode([
//                    'success' => true,
//                    'data' => [],
//                    'message' => 'This is a message from the websocket'
//                ]));
//            }
//        }
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