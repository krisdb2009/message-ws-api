<?php
namespace MessageAPI;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MessageAPI implements MessageComponentInterface {
	
	public function __construct() {
        $this->clients = new \SplObjectStorage();
    }
	
    public function onOpen(ConnectionInterface $conn) {
		$conn->session = new \stdClass();
		$conn->session->channel = '';
		$this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $conn, $msg) {
		if(empty($conn->session->channel)) {
			$msgExp = explode(' ', $msg, 2);
			if($msg == "create") {
				$conn->session->channel = md5(uniqid());
				$conn->send($conn->session->channel);
			} elseif($msgExp[0] == 'join') {
				if(!empty($msgExp[1])) {
					$exists = false;
					foreach($this->clients as $client) {
						if($client->session->channel == $msgExp[1]) {
							$exists = true;
							break;
						}
					}
					if($exists) {
						$conn->session->channel = $msgExp[1];
					} else {
						$conn->close(1008);
					}
				} else {
					$conn->close(1008);
				}
			} else {
				$conn->close(1008);
			}
		} else {
			foreach($this->clients as $client) {
				if($client->session->channel == $conn->session->channel && $conn !== $client) {
					$client->send($msg);
				}
			}
		}
    }

    public function onClose(ConnectionInterface $conn) {
		$this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
		
    }
	
}
?>