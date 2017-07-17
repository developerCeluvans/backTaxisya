<?php

namespace Push;

class iOS {

    public function __construct($tokens, $data, $config, $custom_parameters) {
        $debugLog = FALSE;
        //dd("inteno 1");
        //dd($custom_parameters);
        //dd($data);
        //dd($config);

        //CREATE THE CONNECTION
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $config['cert']);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $config['pwd']);
        //dd($config);
        //OPEN CONNECTION TO THE APNS SERVER
        //$fp = stream_socket_client('ssl://' . $config['host'] . '', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
        $fp = stream_socket_client('ssl://' . $config['host'] . '', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
        //$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp) {
            unset($fp);
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        }
        if ($debugLog == TRUE) {
            $log = new Log('success', 'Connected to APNS' . PHP_EOL);
        }

        //CREATE THE PAYLOAD BODY Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'body' => $data['message'], //.uniqid(),
                'action-loc-key' => $data['action_key']
            ),
            'sound' => $data['sound'],
            'badge' => $data['badge'],
            'extra' => $custom_parameters,
        );

        //ENCODE PAYLOAD AS JSON
        $payload = json_encode($body);
file_put_contents('/tmp/push.txt', 'Push');

        foreach ($tokens as $token) {
            //BUILD THE BINARY NOTIFICATION
file_put_contents('/tmp/push'.$token.'.txt', $token);
            $msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
            //SEND TO THE SERVER
            $result = fwrite($fp, $msg, strlen($msg));
            if (!$result)
            {
                break;
            }
        }

        //CLOSE SERVER CONNECTION
        fclose($fp);
        unset($fp);
    }

}
