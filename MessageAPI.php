<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MessageAPI\MessageAPI;
require('vendor/autoload.php');
require('MessageAPI/MessageAPI.php');

$server = IoServer::factory(
	new HttpServer(
		new WsServer(
			new MessageAPI()
		)
	),
	58756
);

$server->run();
?>