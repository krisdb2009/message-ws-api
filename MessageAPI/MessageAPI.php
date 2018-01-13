<?php
namespace MessageAPI;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MessageAPI implements MessageComponentInterface {
	
    public function onOpen(ConnectionInterface $conn) {
		$conn->send('Welcome!');
    }

    public function onMessage(ConnectionInterface $from, $msg) {
	
    }

    public function onClose(ConnectionInterface $conn) {
		
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
		
    }

}
?>