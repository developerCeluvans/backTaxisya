<?php

// Put your device token here (without spaces):
$deviceToken = '8ff8e49dbea16bf03baeda9a6a1493fc604a2f12fd21e716cdef50207dcceafe'; //Quitar los espacios
$deviceToken = '0ca728ce970bd810f424bdb703addc9aba40e701cc63d5367e201a82914bd5ae';

// Put your private key's passphrase here:
$passphrase = 'imaginamos';

// Put your alert message here:
$message = 'Por ser empleado de Imaginamos, tendras membresia VIP para Taxisya, descubre como!!';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'Distribution.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array('badge' => 2, 'sound' => 'default', 'alert' => array('action-loc-key' => 'Open', 'body' => $message), 'extra' => array('type' => 2));

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);
