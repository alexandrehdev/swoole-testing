<?php

use Swoole\WebSocket\Server as Tchurusbango;




$http = new Tchurusbango('0.0.0.0', 8080);


$http->set(['log_file' => './arquivo.log']);

$http->on('message', function ($server, $frame) {
    $cons = $server->connections;
    $origin = $frame->fd;
    $message = $frame->data;

    foreach ($cons as $con) {
        if ($con === $origin) continue;

        $server->push(
            $con,
            json_encode(["type" => "chat", "message" => $message])
        );
    }
});

$http->start();
